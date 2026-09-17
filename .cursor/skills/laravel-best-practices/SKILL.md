---
name: laravel-best-practices
description: >-
  Use when writing, reviewing, or refactoring Laravel PHP — Eloquent, scopes,
  N+1, validation, jobs, migrations, architecture. Read the mapped rule file
  before editing and apply it strictly. Suave create-* recipes win for
  placement and return contracts.
---

# Laravel Best Practices

Index of detailed **rule** files under `rule/`. Each file is binding guidance (what to do and why), not optional reading. For Suave placement, templates, and return contracts, follow the matching `create-*` skill first.

## Suave overlay (read first)

Read [`rule/suave.md`](rule/suave.md) before any other rule file. Suave conventions override a generic Laravel example when they conflict (named routes, Services + Form Requests, first-party RBAC, Blade marketing assets).

## Consistency first

Match sibling files. Do not introduce a second pattern for the same job. These rules are defaults when no Suave pattern exists yet — not overrides of `create-*` / `system-*` / domain skills.

## How to apply

1. Check nearby code and tests for the established pattern. Deviate only for correctness or security, and say so.
2. Map the concern to the index below. Read **only** the mapped `rule/` file(s) and follow them strictly.
3. Make the smallest coherent change.
4. Run scoped Pint (`vendor/bin/pint --dirty`). Scoped `php artisan test --filter=…` when app/routes/business rules change. Frontend assets/views: see `frontend-audit` + `suave-frontend`.
5. When the user asks to review a branch/PR/diff, use `code-review` (Standards vs Spec).

## Rule index

| Concern | Read |
|---|---|
| Suave deltas (routes, RBAC, Blade, assets) | [`rule/suave.md`](rule/suave.md) |
| DRY, services, constructor DI, architecture | [`rule/architecture.md`](rule/architecture.md) |
| Models, relationships, scopes, casts | [`rule/eloquent.md`](rule/eloquent.md) |
| Query count, eager loading, indexes, large sets | [`rule/db-performance.md`](rule/db-performance.md) |
| Subqueries, aggregates, query plans | [`rule/advanced-queries.md`](rule/advanced-queries.md) |
| Naming, helpers, PHP style | [`rule/style.md`](rule/style.md) |
| Form Requests | [`rule/validation.md`](rule/validation.md) |
| Controllers, route binding | [`rule/routing.md`](rule/routing.md) |
| Schema, FKs, indexes | [`rule/migrations.md`](rule/migrations.md) |
| Jobs, retries, uniqueness | [`rule/queue-jobs.md`](rule/queue-jobs.md) |
| Cache | [`rule/caching.md`](rule/caching.md) |
| Auth, mass assignment, input safety | [`rule/security.md`](rule/security.md) |
| HTTP client | [`rule/http-client.md`](rule/http-client.md) |
| Exceptions, logging | [`rule/error-handling.md`](rule/error-handling.md) |
| Events and notifications | [`rule/events-notifications.md`](rule/events-notifications.md) |
| Mailables | [`rule/mail.md`](rule/mail.md) |
| Scheduler | [`rule/scheduling.md`](rule/scheduling.md) |
| Collections, chunk/lazy | [`rule/collections.md`](rule/collections.md) |
| Config / env | [`rule/config.md`](rule/config.md) |
| Marketing Blade / assets | `suave-frontend` (+ `frontend-audit`) |
| Admin Blade / RBAC | `suave-admin` |
| Diff / PR review | `code-review` |

## Decision rules

- Prefer Laravel features and existing Suave helpers (`createFlashMessage()`, `adminSuccess`, `str()` / `Str`, `MapsDesignAssets`) over new helpers.
- **DRY.** Extract when it removes real duplication — local scopes, `{Feature}Service`, shared Form Request Concerns. Avoid speculative abstractions.
- Prevent N+1 in controllers, services, DataTables, and jobs. `select()` needed columns; constrain `with()`.
