---
name: frontend-audit
description: >-
  Use when auditing or verifying the marketing site for broken images, broken
  internal URLs/404s, missing Section components, or after frontend asset/view
  renames. Run scripts/audit-frontend.php and verify-frontend-conventions.ps1.
---

# Frontend Audit

Integrity checks for the marketing site. Use after asset renames, Blade edits, route changes, or when the user asks to verify no broken images/links/sections.

Also follow [`suave-frontend`](../suave-frontend/SKILL.md) for conventions; this skill is the **verification** workflow.

## When to run

- After renaming or moving `public/assets/**`
- After editing Support path strings, Blade `asset()`, or `route()` links
- After adding/removing Section components or marketing pages
- When the user asks for a site health / broken-link check

## Required commands (agents run these)

1. Tell the user (when also doing convention verify):

   > The changes are being verified and unwanted file functions are being removed

2. Conventions:

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File scripts/verify-frontend-conventions.ps1
```

3. Broken images + internal URLs + page status:

```bash
php scripts/audit-frontend.php
```

Expect: `PASS: no broken images or 404 links.` Exit code `0`.

4. Fix every failure before finishing. Do not leave known 404s or missing asset files.

## What `audit-frontend.php` checks

| Check | Pass criteria |
|---|---|
| Page status | Marketing GET routes return `< 400` (draft Teerrath may **301** to case-studies — OK) |
| Images / static assets | Every `assets/...` file path in rendered HTML and in source strings with a file extension exists under `public/` |
| Internal hrefs | Same-origin `/...` links do not resolve to 404/5xx (301/302 OK) |
| Source string audit | Quoted `assets/...*.{webp,png,jpg,…}` in `app/`, `resources/`, `config/` resolve on disk |

## Section integrity (manual + conventions)

While auditing, also verify Section conventions from `suave-frontend`:

1. Shared multi-page blocks use `App\View\Components\Frontend\{Name}Section` + `<x-frontend.{name}-section />` — not copy-pasted partials when used on **more than two** pages.
2. No orphan Blade that still references deleted section partials or old asset paths.
3. Layout chrome (`Topbar`, `Header`, `Footer`, `Logo`, `Seo`, `SuaveAgent`) is **not** named `*Section`.
4. Background images use inline `style="background-image: url('{{ asset(...) }}')"` — never `bg-[url(...)]` inside `$attributes->merge`.
5. Every `<img>` has non-empty SEO-friendly `alt` and `title` (`verify-frontend-conventions.ps1` enforces this). Optional deeper pass: `php scripts/audit-img-alts.php`.

## Draft / intentional redirects

| Route | Guest behavior |
|---|---|
| `teerrath-case-study` | **301** → `case-studies` when unauthenticated (`draftView`) — not a failure |

Do not "fix" intentional draft gates into public 200s unless the user asks to publish.

## Report format

Summarize:

- Pages smoked / status failures
- Missing assets (path + example source)
- Broken internal hrefs
- Section convention issues found (if any)
- Final: **PASS** or **FAIL** with counts

## Related

- `suave-frontend` — authoring rules + asset folders
- `scripts/asset-path-map.json` — runtime legacy path map (`MapsDesignAssets`) — never delete
- `orchestration-maintenance` — update skills if audit rules change
