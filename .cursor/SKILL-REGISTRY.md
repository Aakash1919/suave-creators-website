# Skill Registry

All skills are `.cursor/skills/{name}/SKILL.md`. Extra markdown allowed only under:

- `laravel-best-practices/rule/*.md`
- `code-review/reference/*.md`
- `suave-frontend/reference.md`

Do not add `INDEX.md`, nested `modules/` trees, or a duplicate `.agents/skills/` copy.

## System / hubs

| Skill | File | Description |
|---|---|---|
| `system-coding-standards` | [system-coding-standards/SKILL.md](skills/system-coding-standards/SKILL.md) | Short Suave constitution; points at LBP + `create-*` + domain skills |
| `laravel-best-practices` | [laravel-best-practices/SKILL.md](skills/laravel-best-practices/SKILL.md) | Deep Laravel + Suave overlay (`rule/suave.md`) |
| `frontend-audit` | [frontend-audit/SKILL.md](skills/frontend-audit/SKILL.md) | Broken images, internal URLs, section integrity checks |

## Layer recipes

| Skill | File | Description |
|---|---|---|
| `create-service` | [create-service/SKILL.md](skills/create-service/SKILL.md) | `App\Services\*`; never HTTP/flash |
| `create-form-request` | [create-form-request/SKILL.md](skills/create-form-request/SKILL.md) | `{Resource}StoreRequest` / `UpdateRequest` |
| `create-migration` | [create-migration/SKILL.md](skills/create-migration/SKILL.md) | Idempotent migrations; never edit live-ran files |

## Domain skills

| Skill | File | Description |
|---|---|---|
| `suave-admin` | [suave-admin/SKILL.md](skills/suave-admin/SKILL.md) | Blade admin, first-party RBAC, DataTables, Toastr, admin CRUD |
| `suave-frontend` | [suave-frontend/SKILL.md](skills/suave-frontend/SKILL.md) | Marketing Blade, assets, CSS, Section components, SuaveAgent |

## Orchestration / workflow

| Skill | File | Description |
|---|---|---|
| `orchestration-maintenance` | [orchestration-maintenance/SKILL.md](skills/orchestration-maintenance/SKILL.md) | After meaningful changes, refresh owning skill + registry |
| `code-review` | [code-review/SKILL.md](skills/code-review/SKILL.md) | Two-axis Standards vs Spec review |

## Ownership notes (no extra skills)

| Concern | Owns it | Do not |
|---|---|---|
| SuaveAgent chat widget / floating icon | `suave-frontend` | Separate chat skill |
| Admin conversation review / ChatLead | `suave-admin` | Parallel messages schema skill |
| Case study marketing catalog + public Blade | `suave-frontend` + notes in `suave-admin` | Separate case-study skill |
| Filament / Spatie Permission / Breeze | — | Never add |
| Vue / Inertia | — | Not this stack |
| Broken image / URL / section checks | `frontend-audit` | One-off undocumented scripts |
| Asset path runtime map | `scripts/asset-path-map.json` via `MapsDesignAssets` | Delete the map |
