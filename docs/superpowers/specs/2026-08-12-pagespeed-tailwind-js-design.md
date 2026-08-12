# PageSpeed: compiled Tailwind + JS deferral

**Date:** 2026-08-12  
**Status:** Approved for planning  
**Scope:** Marketing frontend critical path only — no image/asset re-encoding

## Problem

PageSpeed is hurt by:

1. **Tailwind CDN** (`cdn.tailwindcss.com`) on the marketing layout critical path — runs the full compiler in the browser.
2. **Global Swiper** CSS/JS on every marketing page, including pages with no carousels.
3. **Eager `marked.min.js`** on every page via SuaveAgent, before the chat is opened.

Images and large media stay as-is for this pass (hero/brand PNGs, product GIF, SVG icons untouched).

## Goals

- Serve **compiled Tailwind CSS** instead of the CDN, without changing visual design.
- **Lazy-load `marked`** only when SuaveAgent needs markdown.
- **Load Swiper only** on pages/sections that use it.
- Verify in a **live browser** that styling, carousels, and chat still work.
- Update `suave-frontend` skill so agents do not reintroduce the Tailwind CDN on marketing.

## Non-goals

- WebP/AVIF conversion or responsive image variants
- Compressing/replacing `hero_banner.gif` or large embedded-image SVGs
- Changing Font Awesome or Google Fonts loading strategy (beyond what Tailwind work requires)
- Moving admin layout off Tailwind CDN (admin stays CDN for this pass)
- Adding a Vite JS app bundle to marketing pages

## Approach

**Approach A (approved):** Wire the existing Laravel Vite + Tailwind v4 pipeline into the marketing layout.

`package.json` already has `vite`, `tailwindcss`, `@tailwindcss/vite`. `resources/css/app.css` already imports Tailwind, sources Blade views, and sets PP Mori / border-color compatibility. Only `welcome.blade.php` uses `@vite` today; marketing still loads the CDN.

---

## 1. Compiled Tailwind on marketing layout

### Changes

- In `resources/views/layouts/frontend.blade.php`:
  - Remove `dns-prefetch` for `cdn.tailwindcss.com`.
  - Remove `<script src="https://cdn.tailwindcss.com">` and the inline `tailwind.config = { ... }` block.
  - Add `@vite(['resources/css/app.css'])` on the critical path (alongside existing `style.css` / deferred CSS). Prefer placing Vite CSS early with other critical styles so utilities are available before paint.
- Keep `public/css/style.css` and `style-deferred.css` behavior unchanged.
- Do **not** add `@vite` for `resources/js/app.js` on marketing unless a later task requires it.

### Config / build

- Reuse `resources/css/app.css` and `vite.config.js` as-is unless a build failure requires a narrow fix (e.g. content paths).
- Local: `npm run dev` (or `npm run build`) must be running/built for marketing styles.
- Production deploy must run `npm run build` so `public/build/manifest.json` exists.

### Tests / skill

- Update `tests/Feature/AnalyticsTrackingTest.php` (and any similar asserts) to stop expecting `cdn.tailwindcss.com` on marketing responses; assert Vite-built CSS or absence of the CDN instead.
- Update `.cursor/skills/suave-frontend/SKILL.md` (and the related rule if it restates CDN):
  - Marketing layout uses **compiled Tailwind via `@vite(['resources/css/app.css'])`**, never `cdn.tailwindcss.com`.
  - “No Vite on marketing” becomes: no Vite **JS app bundle** on marketing unless explicitly requested; **CSS via `@vite` is required**.

### Design / functionality constraints

- Utility classes already used in Blade must continue to resolve (Tailwind v4 content scan already covers `../views/**/*.blade.php`).
- No intentional class renames or design tweaks in this pass.
- If a utility is missing after compile, fix `app.css` sources or the class usage — do not fall back to CDN.

---

## 2. Lazy-load `marked` in SuaveAgent

### Current

`resources/views/components/layouts/suave-agent.blade.php` pushes a script stack that eagerly loads `https://cdn.jsdelivr.net/npm/marked@15.0.7/marked.min.js` and uses `window.marked.parse` for assistant bubbles.

### Target

- Remove the static `<script src="...marked.min.js">` from the initial push.
- Add a small loader: on first need (panel open that will render markdown, or first assistant markdown render), dynamically inject the script once, await load, then `setOptions` + `parse` as today.
- Concurrent calls share one in-flight promise so the script is not loaded twice.
- Until loaded, keep existing UX safe (e.g. show plain text or wait briefly for parse — prefer wait-on-promise so streamed markdown still becomes HTML once ready; do not leave permanent raw markdown if the library loads successfully).
- CDN version stays `marked@15.0.7` unless a security pin change is required.

### Constraints

- Chat open/close, start/history/stream, and escalate behavior unchanged.
- Admin markdown (`Str::markdown()`) unchanged.

---

## 3. Conditional Swiper

### Current

`frontend.blade.php` globally loads Swiper CSS (preload + noscript) and Swiper JS (`defer`) for every marketing page.

Swiper is used on: homepage (inline carousels), `articles-insights-section`, `testimonials-section`, `core-values` (if applicable), service detail, industries/industry detail, single blog, and related design mirrors. Inits already guard with `typeof Swiper === 'undefined'`.

### Target

- Remove global Swiper CSS/JS (and matching noscript entries) from `frontend.blade.php`.
- Ensure every Blade surface that constructs `new Swiper(...)` also loads Swiper assets once when that view/component renders:
  - Prefer `@once` + `@push('custom-css')` for CSS and `@once` + `@push('scripts')` for JS (same CDN URLs/versions as today: Swiper 11 bundle).
  - Shared section components (`testimonials-section`, `articles-insights-section`, etc.) own the asset push so any page including them gets Swiper.
  - Page-local carousels (home, service-detail, industries, industry-detail, single-blog) push assets in the same page/section script block if not already covered by a shared component on that page.
- Keep existing init logic and options; only change *where* the library is loaded from (global → on-demand).
- Order: Swiper script must be present before init runs. Prefer loading Swiper JS in the scripts stack **before** page/component init pushes, or load Swiper with `defer`/`onload` and run init after `DOMContentLoaded` only when `Swiper` is defined (existing pattern). If order races appear, use a tiny shared “ensure Swiper loaded then callback” helper consistent with the marked loader — only if needed after live check.

### Constraints

- Pages with no Swiper markup must not request Swiper CSS/JS.
- Carousel behavior, breakpoints, and autoplay must match current behavior on pages that use them.

---

## 4. Live browser verification

After implementation, verify in a real browser (local with Vite running):

| Check | Pass criteria |
|-------|----------------|
| Homepage first paint / hero | Layout, colors, typography match; no missing Tailwind utilities (unstyled content) |
| Homepage Swiper sections | Offerings / digital marketing / portfolio (and any shared sections) init and swipe |
| Services / service detail | Banner logos / capabilities / portfolio swipers work |
| Industries / industry detail | Core services / agile tabs / testimonial swipers work |
| Blog single | Sidebar swiper works |
| SuaveAgent | Panel opens; greeting works; assistant markdown renders after open (marked loads lazily) |
| Non-Swiper page (e.g. contact or legal) | No Swiper network requests; page styles intact |
| Production-like | `npm run build` + page load without Vite dev server still has Tailwind CSS |

Also run `scripts/verify-frontend-conventions.ps1` after the change set and fix reported violations. Tell the user: *The changes are being verified and unwanted file functions are being removed* before that script (per suave-frontend skill).

---

## 5. File touch list (expected)

| Area | Files (indicative) |
|------|--------------------|
| Layout | `resources/views/layouts/frontend.blade.php` |
| Chat | `resources/views/components/layouts/suave-agent.blade.php` |
| Swiper consumers | Shared section components + page Blades that call `new Swiper` |
| Tests | `tests/Feature/AnalyticsTrackingTest.php` (and related if any) |
| Skill | `.cursor/skills/suave-frontend/SKILL.md` (+ rule/AGENTS wording if it hard-codes CDN) |

No changes under `public/assets/` for this pass.

## Success criteria

1. Marketing HTML does not reference `cdn.tailwindcss.com`.
2. Marketing pages load Tailwind from the Vite build (`@vite` / `public/build`).
3. `marked` is not requested until SuaveAgent needs it.
4. Swiper CSS/JS only appear on pages that use Swiper.
5. Live browser checks above pass with no intentional design regressions.
6. Frontend convention verify script passes.

## Risks

- **Missing utilities:** If content paths miss a view, styles break — mitigate with full Blade `@source` (already present) + live visual check.
- **Vite not built in prod:** Blank/missing CSS — document deploy `npm run build`; fail tests if CDN returns.
- **Swiper load order:** Init before script — mitigate with existing `typeof Swiper` guards + live carousel checks; add ensure-loader only if needed.
- **marked race on first stream token:** Mitigate with shared load promise before `parse`.
