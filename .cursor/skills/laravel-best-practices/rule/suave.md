# Suave overlay

Generic Laravel examples in the other `rule/` files are **defaults**. This file wins when they conflict. Layer recipes (placement, template, return) stay in `create-*`. Domain behavior stays in `suave-admin` / `suave-frontend`.

## Always

| Topic | Suave |
|---|---|
| Public / admin URLs | Named routes + `route()` / `redirect()->route()` / `to_route()` — never hardcoded `/admin/...` or `/services/...` path strings |
| Mutations | `App\Services\{Feature}Service` — never HTTP, flash, or `$request->validate()` in a Service |
| Validation | Form Requests `{Resource}StoreRequest` / `{Resource}UpdateRequest` — Admin under `App\Http\Requests\Admin\`, public under `Frontend\` |
| Success flash | `createFlashMessage()` / `adminSuccess()` in the controller — never from a Service |
| RBAC | First-party `roles` / `permissions` only — not Filament, Breeze, or Spatie Permission |
| Marketing UI | Blade + categorized `public/assets/` — not Vue/Inertia; never flat `public/images/` |
| Config | `config()` in app code; `env()` only inside `config/*.php` |
| Mass assignment | Explicit `$fillable` — never `$guarded = []` |
| Migrations | Never edit a migration that already ran on live; guard with `Schema::hasTable` / `hasColumn` (`create-migration`) |

## Local scopes (DRY)

Reusable query constraints belong as **local scopes** on the model. Call them from services, DataTables, and `with()` / `whereHas` closures.

1. **If a scope exists** — **call it**. Never re-state the same `where(...)`.
2. **If the same status/type/`where` appears in 2+ call sites** — add a local scope in the same change, then use it everywhere.
3. Prefer **local** scopes. Reserve global scopes for truly universal constraints (soft deletes). Do not hide admin rows with a silent `PublishedScope`.
4. Match siblings: `public function scopeActive(Builder $query): Builder`.
5. Optional constraints: `->when()` / `->unless()` — never `if` that mutates `$query`. Presence: `filled()` / `blank()`.

### Naming

| Kind | Pattern | Call | Avoid |
|---|---|---|---|
| Flag / threshold | `scopeHas{Thing}` / `scopePaid` | `->hasFeature()`, `->published()` | `scopeWithPublished` for a filter |
| Status / lifecycle | adjective or past participle | `->active()`, `->approved()` | `scopeValid` |
| Discriminator | `scopeOf{Noun}` + param | `->ofType($type)` | `scopeType($type)` |

## Architecture

- Controllers stay thin (HTTP in, flash/JSON/redirect/view out). Persistence lives in Services.
- Constructor-inject Services. No `app()` / `resolve()` for routine DI.
- New admin CRUD → Service **and** Store/Update Form Requests in the **same** change.
- Marketing pages: Support classes under `App\Support\Frontend\` — not fat controllers.

## Performance

- `select()` needed columns; constrain `with('rel:id,col')` (include parent FKs) — especially DataTables.
- Chunk / `lazy()` / `chunkById()` for large sets. Deterministic `orderBy` when paginating.

## Frontend integrity

After marketing view/asset/route changes, run the **`frontend-audit`** skill (broken images, internal URLs, section conventions) in addition to `verify-frontend-conventions.ps1`.
