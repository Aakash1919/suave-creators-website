---
name: suave-frontend
description: >-
  Suave Creators marketing frontend and design-to-Blade imports. Use whenever
  the user mentions homepage, landing page, Blade views, View Components,
  testimonials section, HomeSupport, ContactSupport, design/ folder import,
  public/assets, public/css/style.css, logos, hero images, SuaveAgent chat
  widget, or verify-frontend-conventions. Requires categorized asset paths and
  post-change verification. For admin panel / RBAC / Form Requests use
  suave-admin instead. Read this skill before any frontend change.
---

# Suave Frontend

**Always read this skill** before marketing frontend work. Folder map + rename catalog: [reference.md](reference.md). Admin panel conventions: [suave-admin](../suave-admin/SKILL.md).

## Required after every change set

After importing a page or editing frontend code/assets/CSS:

1. Tell the user exactly:

   > The changes are being verified and unwanted file functions are being removed

2. Run `powershell -NoProfile -ExecutionPolicy Bypass -File scripts/verify-frontend-conventions.ps1`
3. Fix every failure the script reports (do not leave violations)
4. Manually remove leftovers the script cannot auto-delete:
   - Unused import scripts, temp Blade dumps, duplicate logo filenames (`white_logo.svg`, `gradient-logo.svg` as primary paths)
   - Exact duplicate assets (same SHA256) — keep the canonical content name, remap aliases in path maps
   - Core PHP string helpers in components/views when Laravel `str()` / `Str` / `NormalizesAssetPaths` should be used
   - Page JS that belongs in a component (`@once` + `@push('scripts')`)
   - Flat `public/images/` files (must live under `public/assets/...`)
   - Tailwind CDN on marketing layout (use `@vite('resources/css/app.css')`); star-pearl only via `<x-layouts.the-suave-star-pearl />` (never directly in `layouts/frontend.blade.php`)
5. Summarize what was verified and what was removed

## Page import workflow (future pages)

When importing from `design/` (path: `D:\suave-creators\design`, git branch `crm`) into Laravel:

1. Source of truth for markup/CSS/assets: `design/` (keep Blade component structure)
2. Page view: `resources/views/frontend/{page}.blade.php` using `layouts.frontend`
3. Reuse existing Section / Layout components; create new ones only with `Section` postfix
4. Convert design `/images/...` through the asset map:
   - Prefer `scripts/import-home.ps1` patterns (map via `scripts/asset-path-map.json`)
   - New media: place under the correct `public/assets/{category}/` folder first, then reference `asset('assets/...')`
   - If design adds new flat images: copy into the right category (or run `scripts/organize-assets.ps1` then `scripts/rewrite-asset-paths.ps1`)
5. Data props: Support classes (e.g. `app/Support/Frontend/...`), not fat controllers
6. Controllers + named routes: follow **Controllers** and **Routing / links** below
7. Path sanitization: PHP View Components + `NormalizesAssetPaths` — not Blade `str()->ltrim`
8. Component JS: in the component via `@once` + `@push('scripts')`; page-only JS only for non-component blocks
9. CSS: append to `public/css/style.css` under `/* ===== NAME START/END ===== */` markers — never new page CSS files
10. Backgrounds: inline `style="background-image: url('{{ asset(...) }}')"` — never `bg-[url(...)]` inside `$attributes->merge`
11. Finish with the **Required after every change set** verification above

## Controllers

Namespace: `App\Http\Controllers\Frontend\`. Class names are always **singular** (`ServiceController`, `IndustryController`, `BlogController` — never plural).

- **Dedicated controller per page**, thin: load Support data → return the view
- **Services exception:** one `ServiceController` — `index` for `/services`, `show(string $slug)` for all `/service/{slug}` details (no per-service controllers; abort 404 for unknown slugs)
- **Industries exception:** one `IndustryController` — `index` for `/industries`, `show(string $slug)` for all `/industries/{slug}` details (no per-industry controllers; abort 404 for unknown slugs)
- **Blogs:** one `BlogController` — `index` for `/blogs`, `show(string $slug)` for `/blog/{slug}` (abort 404 for unknown slugs; shared single-blog Blade)
- **Case studies:** one `CaseStudyController` — `index` for `/case-studies`, `show(string $slug)` for `/case-studies/{slug}` (abort 404 for unknown slugs; shared single-case-study Blade). Rows come from `case_studies` via `CaseStudySupport`. **Manual admin content only** — never auto-generated
- **Contact:** `ContactController` — `index` for `/contact-us`, `store` for `POST /contact-us` (`contact-us.store`, throttled) via `ContactRequestService`
- **SEO discovery:** `SitemapController` + `App\Services\SitemapService` — `/sitemap.xml`, `/llm.txt` (+ `/llms.txt`), dynamic `/robots.txt` (do not put a static `public/robots.txt` in front of the route; point to llm.txt via a `#` comment only — never an `LLM:` directive)
- Full controller map: [reference.md](reference.md)

## Routing / links

- Every marketing page registers a **named route** in `routes/web.php`
- Internal page hrefs use **`route()` only** — never `url('/path')` or raw paths for marketing pages
- Prefer storing route names (and params) in component/Support defaults, then call `route()` in Blade
- Marketing CTAs that used to go to the contact page use **`ContactSupport::demoHref()`** (`https://calendar.google.com/calendar/u/0/appointments/schedules/AcZssZ2D8d2UlApRNeJryaGldFknb4uF3ua7jFnBA4-ga1Q-lgnLz9K382sK5S2-4J2e-tWD8arDeGXy`) with `target="_blank" rel="noopener noreferrer"` — including header/footer Contact links and page CTAs. Do not point those at `route('contact-us')`
- Same-page contact form anchors on `/contact-us` may still use `#contact-id`
- Contact form: `POST` to `route('contact-us.store')` via AJAX (`novalidate` + custom field errors). On success: clear form and show “The request has been sent successfully.” Also includes `@csrf`, honeypot `website`, and `form_started_at` (bots get silent JSON success)
- Legal pages: `PageController` methods `privacyPolicy` / `termsAndConditions` (`privacy-policy`, `terms-and-conditions`; Footer must use `route()`, not `url()`)
- Sitemap / LLM: `route('sitemap')`, `route('llm.txt')`, `route('robots')` — generated from published blogs, case studies, services, industries, and static pages
- Assets: `asset('assets/...')`; external / `tel:` / `mailto:` stay as-is
- When a named route lands, update Header, Footer, Topbar, SuaveAgent CTAs, and page CTAs that still use `url()`

## SuaveAgent (floating chat)

Site-wide sales chat widget — **not** a contact-page link.

- Layout component: `App\View\Components\Layouts\SuaveAgent` → `resources/views/components/layouts/suave-agent.blade.php` (`<x-layouts.suave-agent />`)
- Toggle + panel brand mark: `<x-layouts.chat-widget-icon />` (classic circular chat SVG)
- CSS: `public/css/style.css` under `/* ===== SUAVE AGENT CHAT ===== */`
- API: `SuaveAgentController` routes `/suave-agent/start|chat|history` in `routes/web.php`
- Agent: `app/Ai/Agents/SuaveAgent.php` (`gpt-4o-mini`) + tools in `app/Ai/Tools/`
- Knowledge/contacts: `SuaveAgentKnowledge` (offices via `ContactSupport::offices()`, SEO org email/phone)
- Persistence: `ChatLead` + Laravel AI SDK conversation tables only; resume via `localStorage` key `suave_agent_session_v1`
- Assistant replies: Markdown (CDN `marked` in the widget; admin review uses `Str::markdown()` — see suave-admin)
- UX: greet + collect name/email (start is instant canned greeting; chat streams “Reviewing…” / “Processing…”); escalate politely via `EscalateToSales`
- Do not point the floating icon at `contact-us`; it opens the chat panel

## TheSuaveStarPearl (brand emblem)

Animated silver star + pearl mark from the drop-in kit.

- Layout component: `App\View\Components\Layouts\TheSuaveStarPearl` → `resources/views/components/layouts/the-suave-star-pearl.blade.php` (`<x-layouts.the-suave-star-pearl />`)
- Assets: `public/assets/brand/the-suave-metallic-star.png`, `the-suave-white-pearl.png`
- JS: `public/js/the-suave-star-pearl.js` (loaded once via `@once` + `@push('scripts')` on the component)
- CSS: `public/css/style.css` under `/* ===== THE SUAVE STAR PEARL ===== */`
- Props: `size`, `decorative`, `ariaLabel`, `starAlt`, `pearlAlt`, `width`/`height`
- Used in Header logo mark
- Do **not** wire star-pearl into `layouts/frontend.blade.php` directly — only via this component

## ChatWidgetIcon (floating chat mark)

Classic circular chat brand mark (dark disc + gradient ring SVG).

- Layout component: `App\View\Components\Layouts\ChatWidgetIcon` → `resources/views/components/layouts/chat-widget-icon.blade.php` (`<x-layouts.chat-widget-icon />`)
- Asset: `public/assets/brand/chat-widget-icon.svg` (PNG variant also available)
- Props: `alt`, `width`, `height`, `src`
- Used by SuaveAgent toggle and panel brand icon

## Company contacts / dual offices

Keep contact details consistent across SEO, footer, contact page, privacy, and SuaveAgent:

- Source of truth: `config/seo.php` organization + `ContactSupport::offices()` / phones
- Offices: Sheridan, WY (USA) and Palampur, Himachal Pradesh (India)
- Phones: `+91 88949 00142`, `+91 18944 55019`
- Email: `info@suavecreators.com`
- When contacts change, update SEO config, ContactSupport, Footer, privacy copy, and `SuaveAgentKnowledge` consumers together

## Assets

- Root: `public/assets/{brand,team,clients,background,hero,blog,portfolio,icons,media,product}/`
- Nested: `blog/blogs-hero`, `icons/tech`
- Files: `asset('assets/...')`; pages: `route()` only
- Logos: `assets/brand/logo-white.webp` (header/footer), `assets/brand/logo.png` (light surfaces)
- **Placement rule:** dedicated folder when it fits; otherwise **`media`**.
- **`clients/`** = real client/partner **company** logos only (e.g. VerySoul, Bioassay). Not tech brands.
- **`icons/tech/`** = tech stack logos/wordmarks (Node.js, React, WordPress, Angular, Vue, PHP, Python, Shopify marks, etc.).
- **`icons/`** = UI/service icons only (filename contains `icon`, or tiny UI marks). Photos/banners/illustrations → `media` (or another dedicated folder).
- **Service capability visuals** (`*-development-icon.svg` with embedded product shots) stay in `icons/`, **not** `icons/tech/`.
- After imports: `scripts/reclassify-assets.ps1` if anything is in the wrong folder.
- After bulk renames: `scripts/rename-assets-by-content.ps1` + `scripts/asset-rename-map.json`.
- **`public/images` must not exist.**
- Do not keep `white_logo.svg` / `gradient-logo.svg` / `logo-white.svg` / `logo.svg` (use `logo-white.webp` / `logo.png`).

### Content naming (required)

Filenames describe the visual — never slot numbers (`tech-dev-1`, `black-logo-7`, `service-mark-logo-3`).

- kebab-case, lowercase, ASCII hyphens; ~3–6 words / under ~60 chars
- No filler: `image`, `photo`, `img`, `banner-1`, `final`, `copy`, `alt` (unless a true second distinct variant)
- **Always confirm brand by rendering/inspecting the asset** — do not guess from design filenames alone
- Known trap: design `black-logo-1.svg` / `black-logo-7.svg` are **Node.js** (identical files), **not** Laravel. Real Laravel color mark is `icons/tech/laravel-color-logo.svg`
- Exact duplicates (same SHA256): keep one canonical file; map old paths to it; delete the duplicate

### Renamed series (do not reintroduce numbered names)

| Design / old pattern | Canonical pattern | Folder |
|----------------------|-------------------|--------|
| `black-logo-*` / `partner-black-logo-*` | brand wordmarks (`nodejs-logo`, `wordpress-logo`, …) | `icons/tech/` |
| `service-logo-*` / `service-mark-logo-*` | color wordmarks (`vue-color-logo`, `php-logo`, …) | `icons/tech/` |
| `com-service-icon-*` / `commerce-service-icon-*` | platform service visuals (`woocommerce-development-icon`, …) | `icons/` |
| `tech-icon-*` / `technology-icon-*` | brand tech icons (`shopify-technology-icon`, …) | `icons/tech/` |
| `tech-dev-*` / `technology-development-icon-*` | stack development visuals (`laravel-development-icon`, …) | `icons/` |

Full old→new tables: [reference.md](reference.md).

### Deduped assets

| Removed duplicate | Kept |
|-------------------|------|
| `laravel-logo-alt.svg` (= former black-logo-7) | `nodejs-logo.svg` (same bytes as black-logo-1/7) |
| `wordpress-logo-alt.svg` (= former black-logo-8) | `wordpress-logo.svg` (same bytes as black-logo-2/8) |

### Helper scripts / maps

| Script / file | Purpose |
|---------------|---------|
| `scripts/organize-assets.ps1` | Flat `public/images/*` → `public/assets/{category}/` |
| `scripts/reclassify-assets.ps1` | Fix misplaced files (`clients`↔`icons/tech`, etc.) |
| `scripts/rename-assets-by-content.ps1` | Apply `asset-rename-map.json` |
| `scripts/rewrite-asset-paths.ps1` | Rewrite `images/...` refs via path map |
| `scripts/asset-path-map.json` | Design + legacy path → current `assets/...` |
| `scripts/asset-rename-map.json` | Relative rename history for re-runs |
| `scripts/verify-frontend-conventions.ps1` | Fail on convention violations |

When renaming: update both JSON maps, rewrite code refs, then verify. Prefer explicit map entries over heuristic `*-N` prefix rewrites for brand logos.

## Image alt + title (required)

Every `<img>` in Blade must have **non-empty** `alt` and `title` attributes (`title` mirrors `alt`).

Alts must be **SEO-friendly**: natural language that describes the image **and** includes relevant service/brand keywords (software development, CRM, SEO, web design, etc.) — not generic labels like “image”, “icon”, or “team member”.

- 5–12 words when possible; keyword-rich but readable (no stuffing)
- Align with the SEO filename when it matches the visual
- Logos: `{Brand} logo partner of Suave Creators {service keyword}`
- Portraits / team: role + context (`Suave Creators UI UX designer…`, `{Name} client testimonial for Suave Creators…`)
- Service icons: `{Service} service icon` with the product/service name spelled out
- Photos: what is shown + why it matters (`SEO analytics dashboard for search engine optimization services`)
- Decorative duplicates (e.g. marquee clone track): same `alt`/`title`; `aria-hidden="true"` on the wrapper
- After bulk edits, run `php scripts/audit-img-alts.php` — expect `missing_alt=0`, `without_title=0`
- `scripts/verify-frontend-conventions.ps1` fails on missing/empty `alt` or `title`

## SEO file naming

- Patterns: photo `professional-man-navy-blazer-portrait.png`; client `verysoul-logo.png`; service icon `web-development-icon.svg`; background `about-section-bg.png`
- Keep `alt` as a full sentence; filename terse and aligned with the visual
- Never reintroduce `team-1`, `client-logo-4`, `dev-icon-1`, `market-1`, `black-logo-N`, `tech-dev-N` style names

## Section components

| Layer | Pattern |
|-------|---------|
| PHP | `App\View\Components\Frontend\{Name}Section` |
| Blade | `resources/views/components/frontend/{name}-section.blade.php` |
| Tag | `<x-frontend.{name}-section />` |

Shared multi-page blocks must be Section components (not `resources/views/frontend/partials/`). Examples: `tech-partnerships-section`, `partnerships-section`, `core-values-section`, `faq-section`, `testimonials-section`, `articles-insights-section`, `marquee-section`, `consultation-section`, `connect-cta-section`, `industries-section`.

Shared CTA chrome: `UiHelper::btnPrimary()` / `UiHelper::ctaArrow()` in `app/Support/Frontend/UiHelper.php`; Blade tags `<x-frontend.cta-button>` and `<x-frontend.cta-arrow />` (do not pass `$btnPrimary` / `$ctaArrow` from controllers).

Name components by **purpose / pattern**, not marketing headline copy (e.g. `connect-cta-section`, not `smart-together-section`).

If the same section markup appears on **more than two pages**, extract a `*Section` component instead of copying Blade.

Layout chrome (`Topbar`, `Header`, `Footer`, `Logo`, `Seo`, `SuaveAgent`, `TheSuaveStarPearl`, `ChatWidgetIcon`) does **not** use `Section`.

## Layout / CSS

- Marketing layout: Tailwind **3.4.17** via Vite (`@vite('resources/css/app.css')`) + Font Awesome subset + `asset('css/style.css')` (+ `style-deferred.css` on non-home pages)
- **Render-blocking:** load those sheets with `media="print" onload="this.media='all'"` (Vite via `Vite::useStyleTagAttributes` when not in HMR). Keep a small inline critical CSS block in `layouts/frontend.blade.php` for the hero LCP shell. Do not reintroduce sync `<link rel="stylesheet">` for those files on the critical path.
- Swiper CSS/JS: lazy via `frontend-deferred.js` when `.swiper` is near the viewport — not global head links
- Pin `tailwindcss` to `3.4.17` (matches former Play CDN); PostCSS + `tailwind.config.js` — not `@tailwindcss/vite` / v4
- Do not use the Tailwind Play CDN (`cdn.tailwindcss.com`) on marketing pages
- Star-pearl emblem only via `<x-layouts.the-suave-star-pearl />` (not wired into `layouts/frontend.blade.php`)
- Do not set `display` on `.u-touch-target` in CSS (breaks responsive utilities)

## Skill maintenance

This is the **only** marketing-frontend project skill. Admin panel / RBAC lives in `suave-admin`. When frontend conventions change, update this skill and `reference.md` in the same change set. Do not recreate split skills for CSS/sections/assets.
