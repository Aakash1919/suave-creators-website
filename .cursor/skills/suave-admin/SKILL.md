---
name: suave-admin
description: >-
  Suave Creators custom Blade admin panel and first-party RBAC. Use whenever the
  user mentions admin, /admin, roles, permissions, Form Request, testimonials
  CRUD, blogs CRUD, users, contacts inbox, AI conversations review, DataTables,
  Toastr, createFlashMessage, EnsurePermission, SiteAdmin, or files under
  routes/admin.php, app/Http/Controllers/Admin, app/Http/Requests/Admin,
  app/Services, app/DataTables/Admin, resources/views/admin. Requires
  App\Services\*Service + Form Requests for mutations — not Filament, Breeze,
  or Spatie Permission. Read this skill before any admin change.
---

# Suave Admin

**Always read this skill** before admin-panel or RBAC work. Marketing frontend stays in `suave-frontend`. Floating chat agent API/widget is documented there; this skill covers the **admin** side of conversations.

## Stack (do not replace)

- Custom Blade admin under `resources/views/admin/` + `resources/views/layouts/admin.blade.php`
- Routes: `routes/admin.php` (prefix `/admin`, name prefix `admin.`), registered from `bootstrap/app.php`
- Middleware aliases: `admin` → `EnsureAdminUser`, `permission:{name}` → `EnsurePermission`
- **Services required for CRUD** — `App\Services\{Feature}Service` holds persistence + domain transforms; controllers stay thin
- **Form Requests required for mutations** — `App\Http\Requests\Admin\*` (and `Frontend\*` for public forms); no `$request->validate()` in controllers/services
- **First-party RBAC only** — tables `roles`, `permissions`, `role_permission`, `user_role`; models `Role`, `Permission`; trait `HasRoles` on `User`
- Do **not** install Filament, Breeze, Jetstream, or Spatie Permission for this panel

## Access model

- Any authenticated user may enter admin (`User::canAccessAdmin()` returns `true`)
- Roles/permissions gate nav and routes (`blogs.*`, `conversations.view`, `contacts.view`, `testimonials.*`, `users.*`, `roles.*`, `profile.update`)
- Seeded site admin: `SiteAdmin::EMAIL` (`admin@suavecreators.com`) / default password `password` via `SiteAdmin::ensure()` + `RolesAndPermissionsSeeder`
- Roles: `admin` (all permissions), `editor` (blogs view/create/update, profile, conversations.view, contacts.view, testimonials.view/manage)
- Roles CRUD: Admin → **Roles** (`roles.view` / `roles.manage`); `admin` role key cannot be renamed or deleted
- Testimonials CRUD: Admin → **Testimonials** (`testimonials.view` / `testimonials.manage`); create/edit use an **index modal** (not separate pages); published items served via `TestimonialService::cachedForFrontend()` (forever cache, forgotten on create/update/delete)

## Services (required)

**Every feature with create / update / delete (or domain-heavy reads) MUST have an `App\Services\{Feature}Service`.** Do not put validation, Eloquent writes, file storage, or transcript transforms in controllers.

| Service | Responsibility |
|---------|----------------|
| `BlogService` | Blog CRUD, slug, featured image, FAQ repeater (TOC admin UI disabled until frontend single-blog uses it), `createDraft()` for trusted internal payloads |
| `BlogDraftGenerationService` | AI trend draft generation via `BlogWriterAgent` → saves `status=draft` |
| `BlogSeoMetaGenerationService` | AI SEO/OG field suggestions via `SeoMetaAgent` → returns values only (edit form fills inputs; editor saves manually) |
| `UserService` | User create/update, password hash, `syncRoles` |
| `RoleService` | Role create/update/delete, permission sync; protects `admin` role key/delete |
| `TestimonialService` | Testimonial CRUD, avatar upload, forever frontend cache (`frontend.testimonials`) invalidated on write |
| `ProfileService` | Own profile + password change |
| `ContactRequestService` | Public contact store + spam checks; admin mark read / archive |
| `ConversationService` | Chat lead thread build + Markdown rendering |

Rules:

1. New admin CRUD → add `App\Services\{Name}Service` **and** `App\Http\Requests\Admin\{Name}StoreRequest` / `{Name}UpdateRequest` in the **same** change as the controller
2. Inject the service in the controller constructor; type-hint Form Requests on store/update; call `$this->{feature}->create|update|delete|…`
3. Controllers only: authorize via middleware (+ Form Request `authorize()`), call the service, return `adminSuccess` / `adminError` / a view
4. Exceptions: `AuthController` logout and `DashboardController` (stats/links) may stay without a service; login still uses `AdminLoginRequest`
5. Services must **not** call `$request->validate()` — they receive an already-validated Form Request (or a trusted array for internal drafts)

## Form Requests

Namespace: `App\Http\Requests\Admin\` (admin) and `App\Http\Requests\Frontend\` (public marketing forms).

**Naming (required):** `{Resource}{Action}Request` — resource first, then action. Examples: `BlogStoreRequest`, `BlogUpdateRequest`. Never `StoreBlogRequest` / `UpdateBlogRequest`.

| Action | Request |
|--------|---------|
| Admin login | `AdminLoginRequest` |
| Blog create/update | `BlogStoreRequest` / `BlogUpdateRequest` (`Concerns\ValidatesBlogFields`) |
| User create/update | `UserStoreRequest` / `UserUpdateRequest` |
| Role create/update | `RoleStoreRequest` / `RoleUpdateRequest` |
| Testimonial create/update | `TestimonialStoreRequest` / `TestimonialUpdateRequest` (`Concerns\ValidatesTestimonialFields`) |
| Profile | `ProfileUpdateRequest` / `ProfilePasswordUpdateRequest` |
| Contact form | `Frontend\ContactStoreRequest` (bot submissions use relaxed rules so silent success still works) |

Conventions:

- One Request per write action (`{Resource}StoreRequest` / `{Resource}UpdateRequest`)
- `authorize()` checks the matching permission (or authenticated user for profile); route `permission:` middleware remains
- Shared field rules live in `App\Http\Requests\Admin\Concerns\*`
- Domain normalization after validation (FAQ arrays, slug uniqueness, image storage) stays in the Service

## Controllers

Namespace: `App\Http\Controllers\Admin\`

| Area | Controller | Service |
|------|------------|---------|
| Auth | `AuthController` | — (`AdminLoginRequest` for login) |
| Home | `DashboardController` | — (stats/links) |
| Blogs | `BlogController` | `App\Services\BlogService` |
| Contacts | `ContactRequestController` | `App\Services\ContactRequestService` (also public store via `ContactStoreRequest`) |
| Profile | `ProfileController` | `App\Services\ProfileService` |
| Users | `UserController` | `App\Services\UserService` |
| Roles | `RoleController` | `App\Services\RoleService` |
| Testimonials | `TestimonialController` | `App\Services\TestimonialService` |
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
- **Admin forms are full width by default** — do not add `max-width` / narrow card constraints on create/edit forms unless the user explicitly asks for a constrained layout
- **Page vs modal (required before building UI):** When adding or changing create / edit / other mutation UX, **ask the user** whether they want a **full page** or a **modal** (unless they already specified). Do not assume. Testimonials use modal create/edit on the index page (`admin/testimonials/partials/form-modal.blade.php` + `.admin-modal*` in `admin.css` + `SuaveAdmin.openAdminModal` / `closeAdminModal`). Page forms stay under `admin/{feature}/form.blade.php`.
- **List pages:** use `<x-admin.datatable>` (`App\View\Components\Admin\Datatable`) for the table shell — page head + Tailwind toolbar (search + always-visible `filters` slot / `<details>` sort & column menus) + table + rows-per-page footer. Slots: `actions`, `filters`. Pass `:columns`, optional `:sort-options`
- Row kebab menus: `App\Support\Admin\DataTableActions::menu([...])` — native `<details>` + Tailwind (no dropdown JS)
- `SuaveAdmin.initDataTable` only wires search/sort/column visibility to Yajra; open/close is CSS/native
- Gate sidebar links with `$user->hasPermission(...)`
- Auth view: `admin.auth.login` (white card on light surface)
- Error pages: `resources/views/errors/{403,404,500}.blade.php` + `errors/layout.blade.php` (centered white card, illustration, primary CTA)
- Feature views: `admin/blogs`, `admin/contacts`, `admin/conversations`, `admin/users`, `admin/roles`, `admin/testimonials`, `admin/profile`, `admin/dashboard`
- Do **not** dump admin styles into marketing `public/css/style.css`

## DataTables + AJAX

- Package: `yajra/laravel-datatables-oracle`
- Server classes: `app/DataTables/Admin/{Blog,User,Role,Testimonial,Conversation}DataTable.php`
- Index controllers return Yajra JSON when `$request->ajax()` / `wantsAdminJson()`; otherwise the Blade list view
- Mutations use `RespondsToAdminAjax` (`adminSuccess` / `adminError`) so store/update/destroy return JSON for AJAX or flash redirects otherwise
- Client helpers in `public/js/admin/suave-admin.js` (`window.SuaveAdmin`):
  - `createFlashMessage` — see **Flash messages** below
  - `toast.*` — thin wrappers; prefer `createFlashMessage` in new code
  - `ajax`, `submitForm` (bind via `data-ajax-form`)
  - `initDataTable`, `reloadDataTable`
  - `initDateRangeFilter` (presets + Flatpickr custom range)
  - `confirmDialog` / `destroyRecord` — see **Confirm dialogs** below
- Forms: add `data-ajax-form` (+ optional `data-success-message`, `data-reload-table`)
- List deletes: `data-admin-delete data-url="..." data-reload-table="#admin-datatable"` (+ confirm attrs — see below)
- Form-page deletes: set `data-reload-table=""` so redirect from JSON is used instead of reloading a missing table

## Confirm dialogs (`SuaveAdmin.confirmDialog`)

**Never use** native `window.confirm()`, `confirm()`, or `onclick="return confirm(...)"` in admin UI. Every destructive or irreversible prompt must use the custom modal.

- Markup (already in the admin layout): `layouts/admin/partials/confirm-dialog.blade.php` (`[data-admin-confirm]`)
- API: `SuaveAdmin.confirmDialog({ title, message, confirmText, cancelText, danger })` → `Promise<boolean>`
- Styles: `.admin-confirm*` in `public/css/admin.css`

### Delete buttons (preferred)

Use `data-admin-delete` — `SuaveAdmin.destroyRecord` opens the custom dialog automatically:

| Attribute | Purpose | Example |
|-----------|---------|---------|
| `data-admin-delete` | Marks the control as a delete action | (presence) |
| `data-url` | DELETE endpoint | `{{ route('admin.blogs.destroy', $blog) }}` |
| `data-confirm` | Body copy (what happens) | `Delete blog “{{ $blog->title }}”? This cannot be undone.` |
| `data-confirm-title` | Dialog title | `Delete blog?` |
| `data-confirm-label` | Confirm button label | `Delete` |
| `data-reload-table` | DataTable selector after success; `""` on form pages to allow JSON redirect | `#admin-datatable` |

DataTable row menus: `DataTableActions::menu([[ 'label' => 'Delete', 'delete' => true, 'url' => …, 'confirm' => …, 'confirmTitle' => …, 'confirmLabel' => 'Delete' ]])`.

### Custom / non-delete confirms (JS)

```js
SuaveAdmin.confirmDialog({
  title: 'Stop SEO audit?',
  message: 'Queued page jobs will be removed. Finished pages stay as a partial report.',
  confirmText: 'Stop audit',
  cancelText: 'Keep running',
  danger: true, // red confirm button + danger icon
}).then(function (ok) {
  if (!ok) return;
  // proceed
});
```

### Copy rules

- **Title:** short question naming the action + resource (`Delete blog?`, `Archive contact?`)
- **Message:** one or two sentences with the consequence; include the record name when known
- **Confirm button:** verb matching the action (`Delete`, `Archive`, `Stop audit`) — not a generic “OK” / “Confirm” when a clearer verb exists
- **`danger: true`** for delete / irreversible / stop actions; omit (primary button) for milder confirms
- Prefer specific copy over “Are you sure?” / “This action cannot be undone.” alone

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

## Run-once commands

One-off maintenance commands live under `app/Console/Commands/RunOnce/` with signature prefix `run-once:…`.

| Command | Purpose |
|---------|---------|
| `run-once:sanitize-blog` | Sanitize blog `content`: extract `data:image/…;base64,…` to `storage/app/public/blogs/content/{slug}-{n}.{ext}`, set `img` `alt` to the blog title, remove empty tags (`<p></p>`, `<span>&nbsp;</span>`, `<h2><br></h2>`, nested empties, etc.), and print a table of sanitized blog URLs |
| `run-once:regenerate-blog-seo-meta` | Regenerate and save `meta_title`, `meta_description`, `og_title`, `og_description` for all blogs via `BlogSeoMetaGenerationService` / `SeoMetaAgent` |
| `run-once:generate-blog-medium-thumbs` | Generate `medium_thumb_image` (480×280) from each blog’s existing `featured_image`; removes legacy `_small` files |

```bash
php artisan run-once:sanitize-blog --dry-run
php artisan run-once:sanitize-blog
php artisan run-once:sanitize-blog --blog=my-post-slug

php artisan run-once:regenerate-blog-seo-meta --dry-run
php artisan run-once:regenerate-blog-seo-meta
php artisan run-once:regenerate-blog-seo-meta --blog=my-post-slug

php artisan run-once:generate-blog-medium-thumbs --dry-run
php artisan run-once:generate-blog-medium-thumbs
php artisan run-once:generate-blog-medium-thumbs --missing-only
php artisan run-once:generate-blog-medium-thumbs --blog=my-post-slug
```

Ensure `php artisan storage:link` exists so `/storage/…` URLs resolve. Safe to re-run.

## AI trend drafts (scheduled)

Console command generates trend-based posts with Laravel AI and always saves them as **drafts** (never auto-publishes):

```bash
php artisan blogs:generate-trend-drafts
php artisan blogs:generate-trend-drafts --count=2
php artisan blogs:generate-trend-drafts --force   # ignore BLOG_TREND_DRAFTS_ENABLED=false
```

Schedule (`routes/console.php`): Tuesdays + Fridays at `BLOG_TREND_DRAFTS_TIME` (default `09:00`, app timezone). Requires server cron: `* * * * * php artisan schedule:run`.

Config: `config/blogs.php` + `.env` (`BLOG_TREND_DRAFTS_*`, `OPENAI_API_KEY`). Agent: `App\Ai\Agents\BlogWriterAgent`.

Generation reads existing posts (titles, category frequency, 2–3 rich style exemplars with heading outlines + opening HTML + sample FAQ) and instructs the model to match that craft: long benefit-led titles, second-person voice, `<h2>`/`<h3>` + `<ul><li><p>` HTML, 5–8 FAQs, `meta_title` ending with `| Suave Creators Blog`, always `status=draft`.

## Edit-form SEO meta (manual save)

On **Edit blog**, “Generate SEO meta” (`POST admin/blogs/{blog}/generate-seo`, permission `blogs.update`) calls `BlogSeoMetaGenerationService` + `SeoMetaAgent` with the current form title / short description / content. It returns `meta_title`, `meta_description`, `og_title`, `og_description` as JSON and the client fills only those inputs — **no DB write** until the editor clicks Save.

Config: `config/blogs.php` → `seo_meta.model` (`BLOG_SEO_META_MODEL`).

## Permissions catalog

Keep names stable; add new ones in `RolesAndPermissionsSeeder` and wire `permission:` middleware on routes:

- `blogs.view|create|update|delete`
- `conversations.view`
- `contacts.view`
- `testimonials.view|manage`
- `users.view|manage`
- `roles.view|manage`
- `profile.update`
- `seo.audit`

## Conventions when changing admin

1. New feature routes go in `routes/admin.php` behind `auth` + `admin` (+ `permission:` as needed)
2. **Always** add/update `App\Services\{Feature}Service` for create/update/delete (and heavy reads); never leave that logic in the controller
3. **Always** add/update Form Requests under `App\Http\Requests\Admin\` named `{Resource}StoreRequest` / `{Resource}UpdateRequest` (e.g. `BlogStoreRequest`) — no inline `$request->validate()` in controllers or services
4. **Ask the user** whether create / edit / other operations should use a **page** or a **modal** before building the UI (unless they already said which)
5. Add PHPDoc on public/protected methods
6. Seed new permissions/roles in `RolesAndPermissionsSeeder` (idempotent `updateOrCreate`)
7. Keep UI in the white-theme admin shell (`admin.css` helpers); do not couple to marketing Tailwind layout patterns unless sharing a deliberate component
8. User feedback: `createFlashMessage` (PHP session or JS Toastr) — never raw `toastr.*` / ad-hoc `Session::flash('status')` in new code
9. Confirmations: **always** `SuaveAdmin.confirmDialog` / `data-admin-delete` with specific title + message + button label — **never** `window.confirm` / `confirm()`
10. When conventions change, update **this** skill and `.cursor/rules/suave-admin.mdc` in the same change set

## Related

- Marketing widget + agent API: `.cursor/skills/suave-frontend/SKILL.md` (SuaveAgent section)
- Agent class/tools: `app/Ai/Agents/SuaveAgent.php`, `app/Ai/Tools/*`
