# Suave Creators — Agent Instructions

Canonical skills live in [`.cursor/skills/{name}/SKILL.md`](.cursor/skills/). Catalog: [`.cursor/SKILL-REGISTRY.md`](.cursor/SKILL-REGISTRY.md). Do not add a duplicate `.agents/skills/` tree.

## Stack

| Layer | Tech |
|---|---|
| Backend | Laravel, PHP 8.x, MySQL |
| Admin | Custom Blade + first-party RBAC (`roles` / `permissions`) |
| Marketing | Blade + `public/assets/` + `public/css/style.css` + Vite Tailwind |
| Tests | PHPUnit Feature/Unit |
| Style | Laravel Pint (PSR-12) |

## Required skill touchpoint

Every change must do one of:

1. Read the relevant `SKILL.md` and follow it.
2. Update that skill when behavior, routes, permissions, assets, or gotchas change.
3. Propose a new skill when a workflow repeats (senior approval; add a registry row).
4. State that the skill was checked and is still accurate.

| Kind | Prefix / name | When |
|---|---|---|
| System | `system-coding-standards` | Shared Laravel/Suave one-liners |
| Laravel rules | `laravel-best-practices` | Eloquent/N+1/architecture — read mapped `rule/` + `rule/suave.md` |
| Layer recipes | `create-*` | Service / Form Request / Migration placement + contracts |
| Domain | `suave-admin`, `suave-frontend` | Admin RBAC vs marketing frontend |
| Integrity | `frontend-audit` | Broken images, internal URLs, section checks |
| Orchestration | `orchestration-maintenance` | After meaningful changes, refresh skill + registry |
| Workflow | `code-review` | Branch/PR Standards vs Spec review |

Admin CRUD → `suave-admin` + matching `create-*`. Marketing pages/assets → `suave-frontend` (+ `reference.md` for renames). After frontend edits → `frontend-audit`. Review a branch → `code-review`.

## Quality gates

Agents **run** these on touched files (do not ask the user to run them):

```bash
vendor/bin/pint --dirty
# when marketing views/assets/CSS changed:
powershell -NoProfile -ExecutionPolicy Bypass -File scripts/verify-frontend-conventions.ps1
php scripts/audit-frontend.php
# when app/ routes/ business rules changed:
php artisan test --filter={TestClass}
```

## Key conventions

- Named routes only: `route()` / `redirect()->route()` / `to_route()`.
- Mutations in `App\Services\*`; validation in Form Requests; thin controllers.
- First-party RBAC only — not Filament, Breeze, or Spatie Permission.
- Marketing media under categorized `public/assets/` — never flat `public/images/`.
- Never edit a migration that already ran on live; guard with `Schema::hasTable` / `hasColumn`.

Project rules under `.cursor/rules/` reinforce the same gates when relevant files are in context.
