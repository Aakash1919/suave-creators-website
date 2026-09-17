# Changes to remove / restore

Rollback guide for the **crawl-budget fix only** (turbo 410 + junk query 301).
Merged via PR #97 → `main` (`83a82a6`). Feature commit: `83db808`.

This file is **not** a `design/` restore guide. The legacy `design/` static prototype was removed from the repo; marketing source of truth is Laravel Blade + `public/assets/` + `public/css/style.css`.

**Live status when documented:** code deployed, production `.env` has `SEO_RETIRED_HOSTS`, Hostinger DNS/parked domain/SSL for `turbo` active. Verified:

- `https://turbo.suavecreators.com/?i=123` → **410 Gone** + `X-Robots-Tag: noindex, nofollow`
- `https://suavecreators.com/?i=123` → **301** → `https://suavecreators.com`

Source context: Google sheet `suavecreators_crawl_stats_dev_fix_plan` (dead subdomain `turbo`, spam query URLs).

---

## Part A — Code

### What this does

1. **HTTP 410** for retired hosts (`turbo.suavecreators.com` by default) via `RejectRetiredHost`.
2. **301-strip** unknown public query params (allowlist only) via `RedirectJunkQueryParams`.
3. Same allowlist applied when building **canonical** URLs in `SeoGenerateService`.

### Delete these files entirely

| File | Role |
|------|------|
| `app/Http/Middleware/RejectRetiredHost.php` | 410 Gone for `seo.retired_hosts` |
| `app/Http/Middleware/RedirectJunkQueryParams.php` | 301 strip non-allowlisted query keys |
| `tests/Feature/CrawlBudgetCleanupTest.php` | Feature tests for the two middlewares |
| `changes-to-remove.md` | This rollback note (optional after full revert) |

### Revert edits in existing files

See git history for `83db808` / PR #97 for the full list of edits to `bootstrap/app.php`, `config/seo.php`, and `SeoGenerateService`. Restore by reverting that commit rather than hand-editing if possible.
