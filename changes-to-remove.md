# Changes to remove / restore

Tracked so recent cleanup work can be rolled back later.

---

## Part A — Crawl budget cleanup (turbo / junk query)

Source context: Google sheet `suavecreators_crawl_stats_dev_fix_plan` (dead subdomain `turbo`, spam query URLs).

## Purpose (what this set does)

1. Return **HTTP 410** for retired hosts (default: `turbo.suavecreators.com`) once DNS points at the same app.
2. **301-strip** unknown public query params (keep allowlisted keys only).
3. Strip the same junk params from **canonical** URLs.

---

## Delete these files entirely

| File | Role |
|------|------|
| `app/Http/Middleware/RejectRetiredHost.php` | 410 Gone for `seo.retired_hosts` |
| `app/Http/Middleware/RedirectJunkQueryParams.php` | 301 strip non-allowlisted query keys |
| `tests/Feature/CrawlBudgetCleanupTest.php` | Feature tests for the two middlewares |
| `changes-to-remove.md` | This rollback note (optional after revert) |

---

## Revert edits in existing files

### 1. `bootstrap/app.php`

- Remove imports:
  - `use App\Http\Middleware\RedirectJunkQueryParams;`
  - `use App\Http\Middleware\RejectRetiredHost;`
- Remove the whole `web(prepend: …)` block that registers `RejectRetiredHost`.
- In `web(append: …)`, remove `RedirectJunkQueryParams::class` (keep `RedirectCanonicalHost::class`).

Target shape after revert:

```php
$middleware->web(append: [
    RedirectCanonicalHost::class,
]);
```

### 2. `config/seo.php`

Delete these two config blocks (and their doc comments):

- `'retired_hosts' => …` (driven by `SEO_RETIRED_HOSTS`)
- `'allowed_query_params' => […]`

Leave `'noindex'` and the rest of the file untouched.

### 3. `.env.example`

Remove:

```env
# Hosts that must return HTTP 410 (point DNS at the same app server first).
SEO_RETIRED_HOSTS=turbo.suavecreators.com
```

### 4. Production / staging `.env` (not in git)

If set, remove:

```env
SEO_RETIRED_HOSTS=…
```

### 5. `app/Services/SeoGenerateService.php` → `canonicalUrl()`

Restore the query-handling branch to only drop pagination:

```php
if ($query !== '') {
    parse_str($query, $params);
    unset($params['page'], $params['per_page']);
    $query = http_build_query($params);
}
```

Remove the `$allowed` / `array_filter(… ARRAY_FILTER_USE_BOTH)` allowlist logic.

---

## Hostinger / DNS (outside the repo)

These are ops steps that paired with the code. Undo only if you are fully abandoning the 410 approach:

1. If an **A/CNAME** for `turbo` was added pointing at production, remove it (back to NXDOMAIN) **or** leave it and stop returning 410 after code revert (site would serve normal app on that host — usually worse).
2. If `turbo.suavecreators.com` was added as a Hostinger alias / SSL host on production, remove that alias if DNS is removed.
3. Staging hardening (`SEO_NOINDEX`, password protect, DNS) was recommended in chat but **not** implemented as new app files in this change set — no code revert required for that.

---

## Quick verify after removal

```bash
php artisan test --filter=CrawlBudgetCleanupTest
# should report no tests / file missing

php artisan test --filter="SeoSitelinksCleanupTest|CanonicalHostTest|RobotsHostTest"
# should still pass
```

Live (after deploy of revert):

```bash
# turbo should no longer be handled by RejectRetiredHost
curl -sI "https://suavecreators.com/?i=123"
# should be 200 again (not 301 to clean URL) if junk middleware removed
```

---

## Git one-liner (if still uncommitted or on a dedicated commit)

If this work is a single commit on a branch:

```bash
git revert <commit-sha>
```

If uncommitted, discard the listed paths only (do not wipe unrelated work).

---

## Part B — `design/` folder removed

The legacy static site under `design/` (PHP prototypes, images, CSS, fonts, and `design/plans/*.md`) was removed from the repo. Live marketing assets live under `public/assets/` and Blade views under `resources/views/`. Deploy already excluded `design/` via `.github/workflows/deploy-laravel.yml`.

### Restore from git

```bash
# Restore the whole tree from the last commit that still had it (usually main / pre-delete commit):
git checkout <commit-before-delete> -- design/

# Or restore from main if design still exists there:
git checkout main -- design/
```

### Related doc/skill tweaks (optional to revert with design)

If restoring `design/`, you may also want to restore older wording in:

- `.cursor/skills/suave-frontend/SKILL.md` (page import from `design/`)
- `.cursor/rules/00-suave-skills.mdc`
- `.cursor/rules/suave-frontend.mdc` (globs including `design/**`)
- `AGENTS.md`

These were updated to stop treating `design/` as an active source of truth.
