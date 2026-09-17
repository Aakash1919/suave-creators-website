---
name: system-coding-standards
description: >-
  Use when writing or reviewing Suave PHP/Laravel, named routes, Pint style,
  Services, Form Requests, migrations, or deciding which domain skill applies.
---

# Coding Standards

Cross-cutting one-liners. Layer recipes live in `create-*`. Deep Laravel rules live in `laravel-best-practices` → `rule/` — read the mapped file and apply it strictly. Suave overlay (`rule/suave.md`) wins when a generic example conflicts. Domain behavior: `suave-admin` / `suave-frontend`.

## Principles

- **Consistency first.** Match sibling files. Do not introduce a second pattern for the same job.
- **DRY.** Extract duplication: local scopes, `{Feature}Service`, Form Request Concerns — not copy-pasted `where`s or flash copy.
- **Prefer Laravel.** Eloquent over raw SQL for CRUD. Helpers: `filled()` / `blank()`, `str()` / `Str`, `to_route()`, `route()`, `collect()`.
- **Named routes everywhere.** `route()` / `redirect()->route()` / `to_route()` — never hardcoded marketing or `/admin/...` paths.
- **Shape reads.** `select()` needed columns; constrain `with()` (include FKs). No N+1.

## Do not

- Filament, Breeze, Jetstream, or Spatie Permission
- Flat `public/images/` (use categorized `public/assets/...`)
- `$request->validate()` in controllers or services
- HTTP / flash / Toastr from a Service
- `env()` outside `config/*.php`
- Edit a migration that already ran on live

## Layers (read the matching skill)

| Layer | Skill |
|---|---|
| Service | `create-service` |
| Form Request | `create-form-request` |
| Migration | `create-migration` |
| Eloquent / N+1 / architecture (deep) | `laravel-best-practices` → `rule/` |
| Admin / RBAC / DataTables | `suave-admin` |
| Marketing Blade / assets | `suave-frontend` |
| Broken images / URLs / sections | `frontend-audit` |
| Diff / PR review | `code-review` |
| After skill-affecting changes | `orchestration-maintenance` |

## Quality

On PHP changes run `vendor/bin/pint --dirty`. On marketing frontend changes run `frontend-audit` + `scripts/verify-frontend-conventions.ps1`. On app/routes/business-rule changes run scoped `php artisan test --filter=…`.
