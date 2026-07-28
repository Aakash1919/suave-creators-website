---
name: suave-admin
description: >-
  Suave Creators custom Blade admin panel: auth, first-party RBAC (roles/
  permissions), blogs CRUD, profile, users, SuaveAgent conversation review,
  App\Services\*Service for every CRUD, createFlashMessage (PHP + JS), Toastr,
  DataTables, and AJAX forms. Use when editing admin routes/controllers/
  services/views, helpers.php, suave-admin.js, EnsureAdminUser /
  EnsurePermission, Role/Permission/HasRoles, SiteAdmin, ChatLead admin UI, or
  RolesAndPermissionsSeeder — not Filament, Breeze, or Spatie.
---

# Suave Admin

**Always read this skill** before admin-panel or RBAC work. Marketing frontend stays in `suave-frontend`. Floating chat agent API/widget is documented there; this skill covers the **admin** side of conversations.

## Stack (do not replace)

- Custom Blade admin under `resources/views/admin/` + `resources/views/layouts/admin.blade.php`
- Routes: `routes/admin.php` (prefix `/admin`, name prefix `admin.`), registered from `bootstrap/app.php`
- Middleware aliases: `admin` → `EnsureAdminUser`, `permission:{name}` → `EnsurePermission`
- **Services required for CRUD** — `App\Services\{Feature}Service` holds validation + persistence; controllers stay thin
- **First-party RBAC only** — tables `roles`, `permissions`, `role_permission`, `user_role`; models `Role`, `Permission`; trait `HasRoles` on `User`
- Do **not** install Filament, Breeze, Jetstream, or Spatie Permission for this panel

## Access model

- Any authenticated user may enter admin (`User::canAccessAdmin()` returns `true`)
- Roles/permissions gate nav and routes (`blogs.*`, `conversations.view`, `contacts.view`, `users.*`, `profile.update`)
- Seeded site admin: `SiteAdmin::EMAIL` (`admin@suavecreators.com`) / default password `password` via `SiteAdmin::ensure()` + `RolesAndPermissionsSeeder`
- Roles: `admin` (all permissions), `editor` (blogs view/create/update, profile, conversations.view, contacts.view)

## Services (required)

**Every feature with create / update / delete (or domain-heavy reads) MUST have an `App\Services\{Feature}Service`.** Do not put validation, Eloquent writes, file storage, or transcript transforms in controllers.

| Service | Responsibility |
|---------|----------------|
| `BlogService` | Blog CRUD, slug, featured image, FAQ repeater (TOC admin UI disabled until frontend single-blog uses it), `createDraft()` for trusted internal payloads |
| `BlogDraftGenerationService` | AI trend draft generation via `BlogTrendWriterAgent` → saves `status=draft` |
| `BlogSeoMetaGenerationService` | AI SEO/OG field suggestions via `BlogSeoMetaWriterAgent` → returns values only (edit form fills inputs; editor saves manually) |
| `UserService` | User create/update, password hash, `syncRoles` |
| `ProfileService` | Own profile + password change |
| `ContactRequestService` | Public contact store + spam checks; admin mark read / archive |
| `ConversationService` | Chat lead thread build + Markdown rendering |

Rules:

1. New admin CRUD → add `App\Services\{Name}Service` in the **same** change as the controller
2. Inject the service in the controller constructor; call `$this->{feature}->create|update|delete|…`
3. Controllers only: authorize via middleware, call the service, return `adminSuccess` / `adminError` / a view
4. Exceptions: `AuthController` (login/logout) and `DashboardController` (stats links) may stay without a service

## Controllers

Namespace: `App\Http\Controllers\Admin\`

| Area | Controller | Service |
|------|------------|---------|
| Auth | `AuthController` | — (login/logout only) |
| Home | `DashboardController` | — (stats/links) |
| Blogs | `BlogController` | `App\Services\BlogService` |
| Contacts | `ContactRequestController` | `App\Services\ContactRequestService` (also public store) |
| Profile | `ProfileController` | `App\Services\ProfileService` |
| Users | `UserController` | `App\Services\UserService` |
| AI chats | `ConversationController` | `App\Services\ConversationService` |

Keep controllers thin: HTTP + `adminSuccess`/`adminError` only. Shared RBAC helpers stay on `HasRoles` / `SiteAdmin`.

## Views & nav

- Layout: `layouts.admin` — **white theme**: light sidebar (`240px`), white topbar, purple primary `#7539FF`, surface `#F7F8F9`; fonts match frontend (`PP Mori` + `Roboto Flex`)
- Partials under `resources/views/layouts/admin/partials/`:
  - `sidebar.blade.php` — light brand bar + soft active nav + user chip; collapses to mini (icons only, hover expands)
  - `header.blade.php` — search, icon actions, avatar dropdown (profile / sign out); hamburger toggles mini sidebar on desktop / overlay on mobile
  - `toastr.blade.php` — [Toastr](https://codeseven.github.io/toastr/) CSS + `window.SuaveAdminFlash` bridge
  - `assets.blade.php` — jQuery, Toastr JS, DataTables JS, Flatpickr JS, `public/js/admin/suave-admin.js`
  - `vendor-styles.blade.php` — DataTables + Flatpickr CSS (loaded in `<head>` **before** `admin.css` so theme overrides win)
  - `flatpickr-styles.blade.php` / `flatpickr-scripts.blade.php` — [Flatpickr](https://flatpickr.js.org/) CDN
  - `richtexteditor-styles.blade.php` / `richtexteditor-scripts.blade.php` — [RichTextEditor](https://richtexteditor.com/) from `public/richtexteditor/`
  - `scripts.blade.php` — sidebar collapse (desktop, `localStorage`) + mobile overlay + user menu
  - `alerts.blade.php` — optional inline alerts (prefer Toastr)
- Styles: `public/css/admin.css` — white theme tokens (`--admin-primary`, `--admin-light`, `--admin-surface`); mini width `--admin-sidebar-collapsed-w: 72px` via `.admin-app.is-sidebar-collapsed`
- Reuse CSS helpers: `.admin-card`, `.admin-table`, `.admin-btn--primary`, `.admin-badge-*`, `.admin-stat`, `.admin-toolbar`
- **List pages:** use `<x-admin.datatable>` (`App\View\Components\Admin\Datatable`) for the table shell — page head + Tailwind toolbar (search + always-visible `filters` slot / `<details>` sort & column menus) + table + rows-per-page footer. Slots: `actions`, `filters`. Pass `:columns`, optional `:sort-options`
- Row kebab menus: `App\Support\Admin\DataTableActions::menu([...])` — native `<details>` + Tailwind (no dropdown JS)
- `SuaveAdmin.initDataTable` only wires search/sort/column visibility to Yajra; open/close is CSS/native
- Gate sidebar links with `$user->hasPermission(...)`
- Auth view: `admin.auth.login` (white card on light surface)
- Error pages: `resources/views/errors/{403,404,500}.blade.php` + `errors/layout.blade.php` (centered white card, illustration, primary CTA)
- Feature views: `admin/blogs`, `admin/contacts`, `admin/conversations`, `admin/users`, `admin/profile`, `admin/dashboard`
- Do **not** dump admin styles into marketing `public/css/style.css`

## DataTables + AJAX

- Package: `yajra/laravel-datatables-oracle`
- Server classes: `app/DataTables/Admin/{Blog,User,Conversation}DataTable.php`
- Index controllers return Yajra JSON when `$request->ajax()` / `wantsAdminJson()`; otherwise the Blade list view
- Mutations use `RespondsToAdminAjax` (`adminSuccess` / `adminError`) so store/update/destroy return JSON for AJAX or flash redirects otherwise
- Client helpers in `public/js/admin/suave-admin.js` (`window.SuaveAdmin`):
  - `createFlashMessage` — see **Flash messages** below
  - `toast.*` — thin wrappers; prefer `createFlashMessage` in new code
  - `ajax`, `submitForm` (bind via `data-ajax-form`)
  - `initDataTable`, `reloadDataTable`
  - `initDateRangeFilter` (presets + Flatpickr custom range)
  - `confirmDialog` / `destroyRecord` (custom modal via `data-admin-delete`, not `window.confirm`)
- Forms: add `data-ajax-form` (+ optional `data-success-message`, `data-reload-table`)
- List deletes: `data-admin-delete data-url="..." data-reload-table="#admin-datatable"`
- Confirm modal markup: `layouts/admin/partials/confirm-dialog.blade.php`
- Form-page deletes: set `data-reload-table=""` so redirect from JSON is used instead of reloading a missing table

## Flash messages (`createFlashMessage`)

PHP builds the toast copy from a resource name — callers never pick a `Session::flash` key or write the full sentence.

### PHP — `app/Support/helpers.php`

Autoloaded via `composer.json` → `autoload.files`.

```php
createFlashMessage('Blog');              // "Blog has been created successfully." (+ session status)
createFlashMessage('Blog', 'updated');   // "Blog has been updated successfully."
createFlashMessage('Blog', 'deleted');   // "Blog has been deleted successfully."
createFlashMessage('Blog', 'created', flash: false); // build only (AJAX JSON path)
```

| `$action` aliases | Verb in sentence |
|-------------------|------------------|
| `created` / `create` (default) | created |
| `updated` / `update` | updated |
| `deleted` / `delete` | deleted |
| `saved` / `save` | saved |

- Always flashes session key `status` when `$flash` is true — do not call `Session::flash('status', …)` yourself
- Prefer `adminSuccess($request, 'Blog', 'created', …)` — it calls `createFlashMessage` (skips session flash on AJAX so Toastr is not doubled after redirect)
- Errors stay custom via `adminError($request, $message)` → session `error`
- Leave Laravel `->withErrors([...])` for field validation

### JS — `SuaveAdmin.createFlashMessage(type, message, title?)`

Client entry point still takes an explicit message string (usually from the JSON `message` returned by `adminSuccess`).

```js
SuaveAdmin.createFlashMessage('success', 'Blog has been created successfully.');
```

- Bridge: `layouts/admin/partials/toastr.blade.php` → `window.SuaveAdminFlash` from session `status` / `error` / `warning` / `info` + `$errors`

## Date range filter (list pages)

- Partial: `layouts/admin/partials/date-range-filter.blade.php`
- Used on **Blogs**, **AI conversations**, and **Contact requests** index page-head actions
- Presets: Today, Yesterday, Last 7 Days, Last 30 Days (default), This Month, Last Month, Custom Range
- Custom Range opens Flatpickr in `mode: 'range'`
- Client sends `date_from` / `date_to` (`Y-m-d`) with DataTables AJAX
- Server: `App\Support\Admin\DateRangeFilter::apply($query, $request, 'table.updated_at'|'table.created_at')`

## RichTextEditor ([richtexteditor.com](https://richtexteditor.com/))

- Self-hosted bundle lives in `public/richtexteditor/` (`rte.js`, `rte_theme_default.css`, `plugins/all_plugins.js`, …)
- Do **not** load the editor globally — include styles/scripts only on pages that need it:
  - `@include('layouts.admin.partials.richtexteditor-styles')` in `@push('styles')`
  - `@include('layouts.admin.partials.richtexteditor-scripts')` in `@push('scripts')`
- Blog toolbar preset `toolbar_blog` (set in the scripts partial): formatting, headings/size, lists, quote, link, image/video, HR, table, HTML source, fullscreen, undo/redo
- Explicitly **omitted**: template, delete, insert comment, save/new/print, cut/copy/paste, find, spellcheck, AI, emoji, gallery, document, revision history, TOC, page break, help, togglemore
- Init via `SuaveAdmin.initRichTextEditor('#blog-content', { height: 640, toolbar: 'blog' })`
  - Seeds textarea value into the editor after construct (API variants: `setHTMLCode` / fallbacks)
  - Periodically syncs editor HTML back into the textarea; `syncRichTextEditors()` also runs before AJAX `FormData`
- Blog form layout: main composer + sticky publish/image sidebar; SEO in a collapsible `<details>` (`admin/blogs/form.blade.php`, `.admin-blog-form*` in `admin.css`)
- FAQ repeater rows (`data-admin-repeater` via `SuaveAdmin.bindRepeaters`) — question + answer; every submitted row is **required**. `BlogService::normalizeFaqItems()`
- **TOC admin UI is commented out** for now (not used on frontend single-blog); existing `blogs.toc` is left unchanged on save. Re-enable form block + `toc` validation / `normalizeTocItems()` together when the frontend needs it
- Override `RTE_DefaultConfig.url_base` is set to `asset('richtexteditor')` in the scripts partial

## Flatpickr ([flatpickr.js.org](https://flatpickr.js.org/))

- CDN loaded via `layouts/admin/partials/flatpickr-*.blade.php` (included in `assets`)
- Auto-init: add `data-flatpickr` on an input; `SuaveAdmin.boot()` calls `bindFlatpickrs()`
- Common attrs:
  - `data-flatpickr-enable-time="true"` (+ default `Y-m-d H:i`)
  - `data-flatpickr-date-format="Y-m-d"`
  - `data-flatpickr-min-date` / `data-flatpickr-max-date`
  - `data-flatpickr-mode="range"`
- Manual: `SuaveAdmin.initFlatpickr('#field', { enableTime: true, dateFormat: 'Y-m-d H:i' })`
- Blog `published_at` uses Flatpickr datetime (`Y-m-d H:i`)

## Conversations (admin)

- Leads: `App\Models\ChatLead` (UUID route key, hashed `session_token`, `escalated_at`)
- Messages live in Laravel AI SDK tables (`agent_conversations` / `agent_conversation_messages`) via `HasConversations` — **no** custom messages table
- List column **Messages** counts rows in `agent_conversation_messages` for the lead (subquery after `select('chat_leads.*')` — never call `select()` *after* `withCount`/`addSelect` or the count is wiped)
- Show page: messenger layout (`admin-messenger*` in `admin.css`) — lead header, optional thread rail, left assistant / right user bubbles, day separators
- Hide internal greeting user prompts that start with `Hello. My name is`
- Render assistant content as Markdown (strip unsafe HTML); escape user text
- Thread build: `ConversationService::threadsForLead()`

## Contact requests (admin)

- Model/table: `ContactRequest` / `contact_requests` (`name`, `email`, `phone`, `service`, `message`, `status` new|read|archived, `ip_address`, `user_agent`)
- Public POST: `contact-us.store` via `ContactRequestService` — honeypot `website`, `form_started_at` min 3s, CSRF, `throttle:5,1`; bots get silent success (no row)
- Admin: `ContactRequestController` + `ContactRequestDataTable`; permission `contacts.view`
- Opening a request marks `new` → `read`; archive via PATCH `admin.contacts.archive`

## Blog seed import (offline)

Do **not** scrape the live site in production. Seed from the committed package via `BlogSeeder`:

- `database/data/blogs/blogs.json` — all posts (content, FAQs, meta, category, dates)
- `database/data/blogs/images/{slug}.{ext}` — featured images renamed to the blog slug
- `database/data/blogs/images/content/*` — inline content images

```bash
php artisan db:seed                 # RolesAndPermissionsSeeder + SiteAdmin + BlogSeeder
php artisan db:seed --class=BlogSeeder
```

`DatabaseSeeder` calls `BlogSeeder` after ensuring the site admin exists.

## AI trend drafts (scheduled)

Console command generates trend-based posts with Laravel AI and always saves them as **drafts** (never auto-publishes):

```bash
php artisan blogs:generate-trend-drafts
php artisan blogs:generate-trend-drafts --count=2
php artisan blogs:generate-trend-drafts --force   # ignore BLOG_TREND_DRAFTS_ENABLED=false
```

Schedule (`routes/console.php`): Tuesdays + Fridays at `BLOG_TREND_DRAFTS_TIME` (default `09:00`, app timezone). Requires server cron: `* * * * * php artisan schedule:run`.

Config: `config/blogs.php` + `.env` (`BLOG_TREND_DRAFTS_*`, `OPENAI_API_KEY`). Agent: `App\Ai\Agents\BlogTrendWriterAgent`.

Generation reads existing posts (titles, category frequency, 2–3 rich style exemplars with heading outlines + opening HTML + sample FAQ) and instructs the model to match that craft: long benefit-led titles, second-person voice, `<h2>`/`<h3>` + `<ul><li><p>` HTML, 5–8 FAQs, `meta_title` ending with `| Suave Creators Blog`, always `status=draft`.

## Edit-form SEO meta (manual save)

On **Edit blog**, “Generate SEO meta” (`POST admin/blogs/{blog}/generate-seo`, permission `blogs.update`) calls `BlogSeoMetaGenerationService` + `BlogSeoMetaWriterAgent` with the current form title / short description / content. It returns `meta_title`, `meta_description`, `og_title`, `og_description` as JSON and the client fills only those inputs — **no DB write** until the editor clicks Save.

Config: `config/blogs.php` → `seo_meta.model` (`BLOG_SEO_META_MODEL`).

## Permissions catalog

Keep names stable; add new ones in `RolesAndPermissionsSeeder` and wire `permission:` middleware on routes:

- `blogs.view|create|update|delete`
- `conversations.view`
- `contacts.view`
- `users.view|manage`
- `profile.update`

## Conventions when changing admin

1. New feature routes go in `routes/admin.php` behind `auth` + `admin` (+ `permission:` as needed)
2. **Always** add/update `App\Services\{Feature}Service` for create/update/delete (and heavy reads); never leave that logic in the controller
3. Add PHPDoc on public/protected methods
4. Seed new permissions/roles in `RolesAndPermissionsSeeder` (idempotent `updateOrCreate`)
5. Keep UI in the white-theme admin shell (`admin.css` helpers); do not couple to marketing Tailwind layout patterns unless sharing a deliberate component
6. User feedback: `createFlashMessage` (PHP session or JS Toastr) — never raw `toastr.*` / ad-hoc `Session::flash('status')` in new code
7. When conventions change, update **this** skill and `.cursor/rules/suave-admin.mdc` in the same change set

## Related

- Marketing widget + agent API: `.cursor/skills/suave-frontend/SKILL.md` (SuaveAgent section)
- Agent class/tools: `app/Ai/Agents/SuaveAgent.php`, `app/Ai/Tools/*`
