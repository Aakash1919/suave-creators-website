# Case study static catalog

Offline source used by frontend support classes for **listing cards, carousels, and sitemap** — not for story detail pages.

| Path | Purpose |
|------|---------|
| `cases.php` | Listing fields (title, image, tags, results, service/industry placement) |

Each public story is an independent Blade page under `resources/views/frontend/case-studies/`. Hero images stay in `public/assets/case-studies/` and are referenced as `asset('assets/case-studies/...')` in those views.

Case studies are **manual only** — there is no AI draft generation.
