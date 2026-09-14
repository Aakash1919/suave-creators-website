# Changes to remove / restore

Rollback guide for the **crawl-budget fix only** (turbo 410 + junk query 301).
Merged via PR #97 → `main` (`83a82a6`). Feature commit: `83db808`.

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

#### 1. `bootstrap/app.php`

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

#### 2. `config/seo.php`

Delete these two config blocks (and their doc comments):

- `'retired_hosts' => …` (driven by `SEO_RETIRED_HOSTS`)
- `'allowed_query_params' => […]`

Leave `'noindex'` and the rest of the file untouched.

#### 3. `.env.example`

Remove:

```env
# Hosts that must return HTTP 410 (point DNS at the same app server first).
SEO_RETIRED_HOSTS=turbo.suavecreators.com
```

#### 4. Production `.env` (not in git)

Remove:

```env
SEO_RETIRED_HOSTS=turbo.suavecreators.com
```

Then `php artisan config:clear` (or rebuild config cache) on the server.

#### 5. `app/Services/SeoGenerateService.php` → `canonicalUrl()`

Restore the query-handling branch to only drop pagination:

```php
if ($query !== '') {
    parse_str($query, $params);
    unset($params['page'], $params['per_page']);
    $query = http_build_query($params);
}
```

Remove the `$allowed` / `array_filter(… ARRAY_FILTER_USE_BOTH)` allowlist logic.

### Allowed query params that were added (for reference)

`page`, `per_page`, `category`, `q`, `utm_source`, `utm_medium`, `utm_campaign`, `utm_term`, `utm_content`, `gclid`, `fbclid`, `msclkid`, `_ga`

### How to revert code

Prefer the **manual deletes/edits above** (Part A only). Do **not** use `git revert -m 1 83a82a6` for crawl-budget rollback alone — that merge also deleted other things and would undo more than this guide covers.

### Quick verify after code removal

```bash
php artisan test --filter=CrawlBudgetCleanupTest
# should report no tests / file missing

php artisan test --filter="SeoSitelinksCleanupTest|CanonicalHostTest|RobotsHostTest"
# should still pass
```

Live (after deploy of revert):

```bash
curl -sI "https://suavecreators.com/?i=123"
# expect 200 (not 301 to clean URL)

curl -sI "https://turbo.suavecreators.com/?i=123"
# if DNS/parked domain still exist and code reverted: expect normal site 200 (bad for SEO)
# so also undo Hostinger Part B below, or keep 410 somehow
```

---

## Part B — Hostinger / DNS / SSL (ops; outside git)

Done on production so Google gets **410** instead of endless DNS errors. Undo only if abandoning the retired-host approach entirely.

### What was added

| Item | Value / location |
|------|------------------|
| DNS record | **ALIAS** `turbo` → `turbo.suavecreators.com.cdn.hstgr.net` (TTL 300). Hostinger may show this after parking even if you first added a CNAME to `suavecreators.com.cdn.hstgr.net`. |
| Parked domain | **Websites → suavecreators.com → Domains → Parked Domains** → `turbo.suavecreators.com` |
| SSL | **SSL certificates** → `turbo.suavecreators.com` Lifetime SSL **Active** |
| Production site | Alias is on **`suavecreators.com`**, not staging |

### How to remove (Hostinger)

1. **Websites → suavecreators.com → Domains → Parked Domains** → remove `turbo.suavecreators.com`.
2. **Domains → suavecreators.com → DNS** → delete the `turbo` ALIAS (or CNAME).
3. **SSL** → remove/revoke the `turbo.suavecreators.com` certificate if Hostinger leaves it orphaned.
4. Wait for DNS; `nslookup turbo.suavecreators.com` should become **NXDOMAIN** again.

**Warning:** If you remove DNS/parked domain **before** removing the 410 code, Google returns to burning crawl budget on DNS errors. Prefer: revert code deploy first **or** keep 410 until crawl stats recover, then delete DNS only if you intentionally want NXDOMAIN again.

### Staging

Staging already had `SEO_NOINDEX` / noindex — **not** part of this change set. Do **not** undo staging noindex when rolling back crawl-budget work. Password-protect / lock staging DNS was considered optional and **was not done**.

---

## Part C — Recommended undo order

1. Deploy code revert (Part A) — **or** keep 410 and skip DNS delete.
2. If fully abandoning turbo retirement: remove parked domain + DNS + SSL (Part B).
3. Delete this file when rollback is finished.

---

## Smoke checks while the fix is still live

```bash
curl -sI "https://turbo.suavecreators.com/?i=123"
# 410 Gone

curl -sI "https://suavecreators.com/?i=123"
# 301 → https://suavecreators.com

curl -sI "https://www.suavecreators.com/"
# 301 → https://suavecreators.com/  (pre-existing; keep)
```
