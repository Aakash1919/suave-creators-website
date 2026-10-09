---
name: suave-frontend
description: >-
  Use when working on the Suave Creators marketing site — homepage, landing
  pages, Blade views, View Components, testimonials, HomeSupport,
  ContactSupport, public/assets, public/css/style.css, logos, hero images,
  SuaveAgent chat widget, named routes, or verify-frontend-conventions.
  Requires categorized asset paths and post-change verification. For admin /
  RBAC use suave-admin. For broken image/URL/section checks use frontend-audit.
metadata:
  last-updated: "2026-10-08"
---

# Suave Frontend

**Always read this skill** before marketing frontend work. Folder map + rename catalog: [reference.md](reference.md). Shared coding: [`system-coding-standards`](../system-coding-standards/SKILL.md). Integrity: [`frontend-audit`](../frontend-audit/SKILL.md). Admin: [`suave-admin`](../suave-admin/SKILL.md). After skill-affecting changes: [`orchestration-maintenance`](../orchestration-maintenance/SKILL.md).

The legacy `design/` static prototype folder was removed from the repo. Source of truth is Laravel Blade + `public/assets/` + `public/css/style.css`. Crawl-budget rollback notes: repo-root `changes-to-remove.md` (not a design restore guide).

## Required after every change set

After editing frontend code/assets/CSS:

1. Tell the user exactly:

   > The changes are being verified and unwanted file functions are being removed

2. Run `powershell -NoProfile -ExecutionPolicy Bypass -File scripts/verify-frontend-conventions.ps1`
3. Run `php scripts/audit-frontend.php` (broken images / internal URLs — see [`frontend-audit`](../frontend-audit/SKILL.md))
4. Fix every failure the scripts report (do not leave violations)
5. Manually remove leftovers the convention script cannot auto-delete:
   - Unused import scripts, temp Blade dumps, duplicate logo filenames (`white_logo.svg`, `gradient-logo.svg` as primary paths)
   - Exact duplicate assets (same SHA256) — keep the canonical content name, remap aliases in path maps
   - Core PHP string helpers in components/views when Laravel `str()` / `Str` / `NormalizesAssetPaths` should be used
   - Page JS that belongs in a component (`@once` + `@push('scripts')`)
   - Flat `public/images/` files (must live under `public/assets/...`)
   - Tailwind CDN on marketing layout (use `@vite('resources/css/app.css')`); star-pearl only via `<x-layouts.the-suave-star-pearl />` (never directly in `layouts/frontend.blade.php`)
6. Summarize what was verified and what was removed

## New or updated marketing pages

Work directly in Laravel (no `design/` import step):

1. Page view: `resources/views/frontend/{page}.blade.php` using `layouts.frontend`
2. Reuse existing Section / Layout components; create new ones only with `Section` postfix
3. Media: place under the correct `public/assets/{category}/` folder, then reference `asset('assets/...')`
4. Data props: Support classes (e.g. `app/Support/Frontend/...`), not fat controllers
5. Controllers + named routes: follow **Controllers** and **Routing / links** below
6. Path sanitization: PHP View Components + `NormalizesAssetPaths` — not Blade `str()->ltrim`
7. Component JS: in the component via `@once` + `@push('scripts')`; page-only JS only for non-component blocks
9. CSS: append to `public/css/style.css` under `/* ===== NAME START/END ===== */` markers — never new page CSS files
10. Backgrounds: inline `style="background-image: url('{{ asset(...) }}')"` — never `bg-[url(...)]` inside `$attributes->merge`
11. Finish with the **Required after every change set** verification above

## Controllers

Namespace: `App\Http\Controllers\Frontend\`. Class names are always **singular** (`ServiceController`, `IndustryController`, `BlogController` — never plural).

- **Dedicated controller per page**, thin: load Support data → return the view
- **Custom CRM Builder landing:** `CustomCrmBuilderController@index` for `/custom-crm-builder` (`custom-crm-builder`). Dedicated Blade + `CustomCrmBuilderSupport` — **not** `ServiceController` / `service.show` / `ServiceSupport::SLUGS`. SEO is `config/seo.php` `pages.custom-crm-builder`; `json_ld_breadcrumb_parent_name` + `json_ld_breadcrumb_parent_route` insert a parent crumb (Services) via `SeoGenerateService`. Extra Service JSON-LD comes from `CustomCrmBuilderSupport::seoStructuredData()`. Trust stats (`.crm-builder-trust__stats`, also reused on the enterprise page) are two cards per row below 768px, with smaller value, label, and detail type. From 768px to 1023px they stay stacked. From 1024px they are one row.
- **Suave CRM product landing:** `ProductController@index` for `/free-all-in-one-crm` (`product`); `/ai-powered-outreach-crm` 301s to it (`product.legacy`). Nav and footer label is “AI CRM”. Every footer column ends with an unconditional “Explore the AI CRM (The Suave App)” link to `product` (no column-title check). Copy follows the revised content doc and lives in `ProductSupport`. Section order: hero, `product-glance` (at a glance table, dark, inside `.product-top-shell`), how-it-works (sales), add-ons (“What you save” comparison table `product-compare`), then `featureSections()` rendered by one Blade loop as `product-module` sections (projects, time and billing, team and HR, AI `#business-works`, who it’s for, getting started `numbered`, why teams switch; even sections get `product-module--tint`; card icons are Font Awesome subset classes), data privacy, `<x-frontend.testimonials-section id="testimonial" :items="$testimonials">` (only `ProductSupport::testimonials()`: the content doc’s Amit Rana quote plus one placeholder Suave Creators Team quote, not database testimonials; its default slot holds the “See more client results” `case-studies` button, so `ProductPageTest` uses `RefreshDatabase`), FAQ, sales CTA (Sign Up Free, plus `secondary-dark` Book a Demo and custom CRM development buttons). Sign Up Free CTAs use `<x-frontend.cta-button>` and point at `ContactSupport::demoHref()` until a real sign-up URL exists. A sticky mobile bar (`product-sticky-cta`, `@push('fixed-widgets')`) shows below 768px only after the hero leaves the viewport and hides while `#sales-cta` is visible; `body.has-product-sticky-cta` lifts `.floating-chat` to `bottom: 76px`. The FAQ and testimonials sit inside `.product-page`, so `.product-page > .faq-section > .section-inner` and `.product-page > .testimonial-section > .section-inner` supply the container width. CSS lives in `style-deferred.css` under PRODUCT. The `product-case-study` styles stay because the Turbo Trans case study page reuses them.
- **Enterprise AI & ERP UAE landing:** `EnterpriseAiErpController@index` for `/uae/services/enterprise-ai-erp-solutions` (`enterprise-ai-erp-uae`). The page is not live yet, so do not add 301s from `/enterprise-ai-erp-uae` or `/services/uae/enterprise-ai-erp-solutions`. Dedicated Blade + `EnterpriseAiErpSupport`. Standalone: do **not** add it to Header, Footer, services, or industries. The announcement bar on this route only reads “Enterprise AI in Action” and still links to The Suave App. SEO is `config/seo.php` `pages.enterprise-ai-erp-uae` with a Services breadcrumb parent, `en` / `en-ae` / `x-default` hreflang, and `og:locale` `en_AE`. Hero background is `assets/media/erp-banner-bg.webp` (`bannerBackgroundImage`), set with an inline `background-image` on `.enterprise-ai-erp-hero`. The secondary connect button (`.enterprise-ai-erp-hero__cta-secondary`) uses `assets/media/soft-white-right-arrow.png` beside the label. The hero visual (`.enterprise-ai-erp-hero__visual`) is a positioned composition matching the laptop-and-cards artwork: the laptop (`heroVisualImage`, `assets/media/laptop-image.webp`) is anchored to the bottom of the frame, Bilingual Arabic-English and UAE Regulatory Compliance sit across the top, and Custom ERP Platforms and AI-Powered Automation stack down the left. Slot classes are `enterprise-ai-erp-hero__feature--bilingual`, `--platforms`, `--automation`, and `--compliance`. Below 768px those cards leave absolute positioning and sit in a two-column grid, and `.enterprise-ai-erp-hero__media` is hidden. From 768px to 1199px the same two-column card grid stays left-aligned across the content width, with the laptop left-aligned under the cards. The visual is not centered and has no 40rem cap in that range. Icons are `assets/media/arabic-english-logo.webp`, `custom-erp-logo.png`, `ai-logo.webp`, and `compliance-logo.webp`. An empty `heroFeatures[].icon` still renders `enterprise-ai-erp-hero__icon-placeholder`, and an empty `heroVisualImage` still renders `enterprise-ai-erp-hero__image-placeholder`. Open Graph uses `assets/media/enterprise-ai-erp-og-banner.webp` (1200×630 crop of the laptop-and-cards artwork). The previous composite `assets/media/enterprise-erp-banner.webp` is removed. The trust and credibility block below the hero reuses the full-bleed `crm-builder-trust-band` stats styles. Its heading (`trustTitle`) is centered via `.enterprise-ai-erp-trust__title`; the CRM eyebrow, description, and services link are omitted. Copy and stats live in `EnterpriseAiErpSupport`. The strategic capital allocation section below the definition block uses five `<img>` collage slots (`enterprise-ai-erp-allocation__tile`, including the center circle). Swap each `src` in `EnterpriseAiErpSupport::allocationVisuals()` when the final `assets/media/` photos land. The TCO comparison below it reuses the `crm-builder-tco` table markup and styles. Its header-row icons stay empty placeholders (`enterprise-ai-erp-tco__icon-placeholder`) until `metricIcon`, `saasIcon`, and `customIcon` are set in `EnterpriseAiErpSupport::tco()`. The modules carousel below the table (`enterpriseModulesSwiper`, inited with `suaveWhenSwiperReady`) shows four cards per view from 1200px and two from 768px. Its full-bleed background is `assets/background/enterprise-ai-erp-modules-bg.webp` (`modules.backgroundImage`), set with an inline `background-image` on `.enterprise-ai-erp-modules`. Card icons stay empty placeholders (`enterprise-ai-erp-modules__icon-placeholder`) until each `items[].icon` path is set. The vertical industry section below the modules (`enterprise-ai-erp-verticals`) is a full-bleed carousel (`enterpriseVerticalsSwiper`, inited with `suaveWhenSwiperReady`) that keeps the photo-plus-overlapping-logo card layout and shows three cards from 1200px, two from 768px, and one below that. Previous and next controls sit in a row under the cards (`.enterprise-ai-erp-verticals__nav`). Extra industries slide in. The swiper rule must stay more specific than Swiper’s stylesheet (`.enterprise-ai-erp-verticals .swiper.enterprise-ai-erp-verticals__swiper`) so its padding is not reset and the card shadow is not clipped. Each slide clips with `overflow: hidden` and `padding: 10px 18px 24px 14px`, and `spaceBetween` stays `0`, so the card shadow (`3px 6px 14px 0px #00003F0F`) renders inside that slide. The next card’s shadow stays off-screen until that slide enters. Each card matches the photo-plus-overlapping-logo layout: a top photo, a white badge sitting on the photo’s lower-left edge, then title, operational challenge, and custom architecture. Card photos stay empty placeholders (`enterprise-ai-erp-verticals__image-placeholder`) until each `items[].image` path is set, and card logos stay empty placeholders (`enterprise-ai-erp-verticals__logo-placeholder`) until each `items[].logo` path is set, in `EnterpriseAiErpSupport::verticals()`. The regulatory block below that (`enterprise-ai-erp-governance`) is a full-bleed two-column layout: copy on the left, and on the right four separate white cards stacked with a gap. Each card uses a blue `border-left` on the card itself. Copy comes from `EnterpriseAiErpSupport::governance()`. The architectural standards block below that (`enterprise-ai-erp-stack`) is a full-bleed dark section: an eyebrow and heading, then five rows. Its background is `assets/background/enterprise-ai-erp-stack-bg.webp` (`stack.backgroundImage`), set with an inline `background-image` on `.enterprise-ai-erp-stack`. Each row (`.enterprise-ai-erp-stack__row`) has background `#0B1036` and is a left category block plus a five-column tech-card grid. Core Backend Frameworks fills that row with Laravel, PHP, Node.js, NestJS, and Python. Shorter rows keep the same card width and height as the first row and leave the unused columns empty. Items are grouped with `chunk(2)`. Below 768px each group is one snap slide of two cards. From 768px to 1199px those groups flatten (`display: contents`) and three cards stay in view. Below 1200px the cards sit in one sideways row, three visible at a time, and keep scrolling until every card in the group is reached. From 768px to 1199px each `.enterprise-ai-erp-stack__card` is shorter (`min-height: 120px`, tighter vertical padding and a 28px icon). Phone and desktop keep `min-height: 168px`. From 1200px up `.enterprise-ai-erp-stack__pair` is `display: contents` so the five-column grid is unchanged. On the same 768–1199px range, `.site-main--enterprise-ai-erp .faq-section__intro` stays centered in normal flow so the eyebrow does not overlap the heading. A 2px vertical stroke (`linear-gradient(90deg, #2A4DFB 0%, #7A5FF8 100%)`) sits at the end of `.enterprise-ai-erp-stack__intro`. Frontend & Dashboards lists ReactJS, Next.js, Tailwind CSS, and WebSockets. Databases & Vector Storage includes MySQL and MongoDB. AI Orchestration & LLMs includes AWS. The cross-border delivery block below that (`enterprise-ai-erp-delivery`) is a light three-card grid from 1024px. Each card is a top photo, a blue circular logo sitting on the photo’s lower-left edge, then a blue title and body copy. Card photos stay empty placeholders (`enterprise-ai-erp-delivery__image-placeholder`) until each `items[].image` path is set, and card logos stay empty placeholders (`enterprise-ai-erp-delivery__logo-placeholder`) until each `items[].logo` path is set, in `EnterpriseAiErpSupport::delivery()`. The engineering lifecycle below delivery (`enterprise-ai-erp-lifecycle`) is a five-step timeline: numbered blue circles on a dashed rail, then a white outer card (`.enterprise-ai-erp-lifecycle__card`) with a bluish inner panel (`.enterprise-ai-erp-lifecycle__panel`) that holds the stage copy on the left and a deliverable on the right. Stage icons stay empty placeholders (`enterprise-ai-erp-lifecycle__icon-placeholder`) until each `items[].icon` path is set in `EnterpriseAiErpSupport::lifecycle()`. Below the lifecycle, the page reuses the CRM dark FAQ (`faq-section--crm-builder`, `:show-cta="false"`), then the evidence carousel (`enterprise-ai-erp-evidence`, `enterpriseEvidenceSwiper`) showing three result cards from 1200px and one at the default breakpoint. Previous and next controls sit in a row under the cards (`.enterprise-ai-erp-evidence__nav`). Evidence cards use `box-shadow: 3px 6px 14px 0px #00003F0F`. Each evidence slide clips with `overflow: hidden` and `padding: 10px 18px 24px 14px`, and `spaceBetween` stays `0`, so that shadow stays inside the slide. The next card’s shadow stays off-screen until that slide enters. The swiper rule must stay more specific than Swiper’s stylesheet (`.enterprise-ai-erp-evidence .swiper.enterprise-ai-erp-evidence__swiper`). Evidence card logos are set in `EnterpriseAiErpSupport::evidence()` (`assets/media/ttc-logo.webp`, `b2b-crm-logo.webp`, `ai-sales-logo.webp`, `automation.webp`). Empty `items[].icon` still renders `enterprise-ai-erp-evidence__icon-placeholder`. Then `<x-frontend.consultation-section />`, then the partnerships logo grid (`crm-builder-partners`, same `partnerLogos` filter as the CRM page). FAQ and consultation copy live in `EnterpriseAiErpSupport`. CSS lives in `style-deferred.css` under `ENTERPRISE AI ERP`. The layout only loads that file when the route is in `$loadDeferredCss` in `layouts/frontend.blade.php` — keep `enterprise-ai-erp-uae` on that list.
- **Services exception:** one `ServiceController` — `index` for `/services`, `show(string $slug)` for all `/services/{slug}` details (no per-service controllers; abort 404 for unknown slugs)
- **Industries exception:** one `IndustryController` — `index` for `/industries`, `show(string $slug)` for all `/industries/{slug}` details (no per-industry controllers; abort 404 for unknown slugs)
- **One Blade per service / industry slug:** `show()` calls `ServiceSupport::showData($slug)` / `IndustryDetailSupport::showData($slug)` first (404 guard), then renders `frontend.services.{slug}` / `frontend.industries.{slug}`. There is no shared `service-detail` / `industry-detail` template. Each page composes Section components in order; copy stays in `app/Support/Frontend/Data/{services,industries}/{slug}.php`. `showData()` merges `detailDefaults()` under the data, so page Blades read `$service['key']` / `$industry['key']` with no `??`. Adding a page = slug in `SLUGS` / `SLUG_FILES` + data file + page Blade. Service modal pre-select values are hardcoded per page (`primary-service` / `service`) and must match the contact modal option values (`web-development`, `custom-crm`, `enterprise-software`, `ecommerce`, `ui-ux-design`, `ai-solutions`).
- **Blogs:** one `BlogController` — `index` for `/blogs`, `show(string $slug)` for `/blog/{slug}` (abort 404 for unknown slugs; shared single-blog Blade)
- **Case studies:** one `CaseStudyController` — `index` for `/case-studies`; dedicated static methods for each story (`/turbo-trans-case-study`, `/outreach-case-study`, `/ai-sales-coaching-case-study`, and the other catalog routes). Each story is an independent Blade page under `resources/views/frontend/case-studies/` (copy and images live in that view — not loaded from Support). Listing cards, carousels, and sitemap read the static catalog in `CaseStudySupport` — not `database/data/case-studies/cases.php` and not the `case_studies` table. Per-story SEO is in `config/seo.php` `pages`. Old `/case-studies/{slug}` URLs 301 to the static routes (`case-study.show`). Placement: `service_slugs` drive the light `<x-frontend.case-studies-carousel-section>` on `/services` (static `CaseStudySupport::servicesPageItems()`) and `/service/{slug}`; `industry_slugs` drive the same carousel on `/industries` (static `CaseStudySupport::industriesPageItems()`) and `/industries/{slug}`
- **Contact:** `ContactController` — `index` for `/contact-us`, `store` for `POST /contact-us` (`contact-us.store`) and `draft` for `POST /contact-us/draft` (`contact-us.draft`) via `ContactRequestService`. The hero pair is **Hire Developers** (`hire-developers-dialog`) and **Get a Scoped Estimate** (`project-estimate-dialog`); both inquiry modals are included on this page. The form Service field uses `<x-frontend.modal.inquiry-select />` with `ContactSupport::formServiceOptions()`.
- **SEO discovery:** `SitemapController` + `App\Services\SitemapService` — `/sitemap.xml`, `/llms.txt` (legacy `/llm.txt` 301s here), dynamic `/robots.txt` (do not put a static `public/robots.txt` in front of the route; point to llms.txt via a `#` comment only — never an `LLM:` directive)
- **Retired hosts:** `RejectRetiredHost` returns **HTTP 410** (not 301) for `config('seo.retired_hosts')` / `SEO_RETIRED_HOSTS` (`turbo.suavecreators.com`, `backend.suavecreators.com`). Apex and `www.` variants both match. Point DNS/SSL at the same app first. Canonical www→apex 301 (`RedirectCanonicalHost`) only applies to `www.` + `APP_URL` host, not retired subdomains
- Full controller map: [reference.md](reference.md)

## Routing / links

**Every app URL is a named route.** Callers use `route()` / `redirect()->route()` / `to_route()` so a path or slug change is made in the route definition (and slug catalog) once — not by hunting hardcoded `/industries/...` strings.

- Every marketing page registers a **named route** in `routes/web.php` (`->name(...)`). No anonymous/unnamed marketing routes
- Internal hrefs, redirects, sitemap/llms entries, tests, and smoke scripts use **`route('name')` or `route('name', $params)` only** — never `url('/path')`, `redirect('/path')` (except the inbound retired URI), or raw `'/services/...'` / `'/industries/...'` path strings
- Prefer storing **route names + params** (or catalog slugs) in component/Support defaults, then call `route()` in PHP/Blade. Do not duplicate URL path prefixes in data files
- Tests: `$this->get(route('industry.show', ['slug' => $slug], false))` (and the same for other pages). `assertRedirect(route(...))`. A retired inbound path may stay a literal because it is not a named route
- Legacy 301s: hardcode **only the old inbound URI**. The destination **must** be `redirect()->route(...)` — e.g. `Route::get('/industries/healthcare', fn () => redirect()->route('industry.show', ['slug' => 'healthcare-software-development'], 301))`
- Header nav **Contact** and footer **Contact Us** links use **`route('contact-us')#contact-id`** (same-tab, to the contact form)
- Marketing booking CTAs (Talk to an expert, Book a Call, demo/consultation buttons) use **`ContactSupport::demoHref()`**, which returns `route('contact-us', absolute: false).'#contact-id'` so the visitor lands on the contact form. Same-tab — do not add `target="_blank"`
- **Inline consultation field** (`inline-consultation-form`): the phone/email input stays on the homepage only (`show-field`). On that hero the secondary label sits inside the email pill, before the primary button. Every other page renders that component as two CTAs. The primary button opens the Suave Agent panel (`SuaveAgent.open()`, `data-consultation-open-agent`). The secondary link uses `ContactSupport::demoHref()`. Do not put the contact input back on non-home heroes. Left-aligned banners (services, industries, service and industry detail) pass `align="start"`. The about banner and centered sections below the hero stay `align="center"`.
- **Homepage final section** (`home-final`): H2 “Ready to Build or Scale Your Product?”, then Get a Project Estimate and Hire Developers cards. Get a Project Estimate `.home-final__icon` (card) uses `assets/product/document.png`. Hire Developers `.home-final__icon` (card) uses `assets/team/teamwork-icon.svg`. Each button (`data-inquiry-dialog-open`) opens its reusable inquiry modal. Other homepage buttons that would open `#contact-modal` open the same dialogs: `hire-developers` opens the hire dialog, every other service opens the estimate dialog and pre-selects that service. When the trigger sits inside `form[data-consultation-form]`, or any homepage consultation `input[name="contact"]` has a value, a valid email is copied into the dialog’s Work Email field (including home-final Hire/Estimate buttons). Include on any page with `<x-frontend.modal.project-estimate-modal />` and/or `<x-frontend.modal.hire-developers-modal />` (`App\View\Components\Frontend\Modal\*`, blades under `resources/views/components/frontend/modal/`). Options come from `ContactSupport::projectEstimateServices()` / `projectEstimateBudgets()` / `hireExpertiseOptions()` / `hireSupportOptions()` / `hireStartOptions()`. Estimate posts `inquiry=project-estimate`; hire posts `inquiry=hire-developers`, `service=hire-developers`, plus required expertise, support type, and start. Company is required on both. Both `POST` to `contact-us.store` and draft to `contact-us.draft`. `inquiry` makes phone optional. Shared CSS is `/* ===== INQUIRY MODALS ===== */` in `public/css/style.css` (`.inquiry-modal`, `.inquiry-select`). Dropdowns use `<x-frontend.modal.inquiry-select />` (contact-modal style listbox with icons), not native `<select>`. Shared open/validate/submit JS is `@once` from `inquiry-modals-script.blade.php` (`data-inquiry-dialog`, validate on submit only). Dialogs `@push('fixed-widgets')` so they sit at body level after the footer. The direct line uses the US office email, phone, and `route('contact-us')#contact-id`. Close with the X, the backdrop, or Escape.
- Same-page contact form anchors on the contact page may still use `#contact-id`
- Contact form: `POST` to `route('contact-us.store')` via AJAX (`novalidate` + custom field errors). Field `blur`/`change` also `POST`s to `route('contact-us.draft')` (silent; one `draft_token` row) so abandoned forms still save name/email/phone/service/message. On submit success: clear form and show “The request has been sent successfully.” Also includes `@csrf`, honeypot `website`, and `form_started_at` (bots get silent JSON success)
- Legal pages: `PageController` methods `privacyPolicy` / `termsAndConditions` (`privacy-policy`, `terms-and-conditions`; Footer must use `route()`, not `url()`)
- Google tags (site verification meta, GA4 `gtag`, GTM script + noscript iframe) render **only when `app()->isProduction()`**; `layouts/frontend.blade.php` nulls the `config('seo.site.*')` IDs elsewhere, which also stops `frontend-deferred.js` loading gtag.js / gtm.js
- Sitemap / LLM: `route('sitemap')`, `route('llms.txt')`, `route('robots')` — generated from published blogs, case studies, services, industries, and static pages
- Assets: `asset('assets/...')`; external / `tel:` / `mailto:` stay as-is
- When adding a named route, wire Header, Footer, Topbar, SuaveAgent, and page CTAs with `route('the-new-name')` — do not add raw paths

## Laravel coding standards

Follow Laravel conventions (PSR-12). Do not invent a parallel style guide.

- Run `vendor/bin/pint --dirty` after PHP edits (Laravel Pint is installed)
- Thin controllers: HTTP in, view / `redirect()->route()` / JSON out. Frontend data lives in Support classes; admin mutations live in `App\Services\*`
- Validate with Form Requests — no `$request->validate()` in controllers or services
- Type-hint arguments and return types; use constructor promotion
- Unknown slugs/records: `abort(404)` or `findOrFail()`
- Use framework helpers that already exist: `str()` / `Str`, `filled()` / `blank()`, `to_route()`, `route()`, `asset()`
- `config()` in application code; `env()` only inside `config/*.php`
- Keep `routes/*.php` declarative (route list + one-line named redirects). No domain logic in the route file
- Eloquent models for persisted data — do not add a query-builder-only parallel when a model exists
- Blog cards/listings (`BlogSupport::posts()`, `articleCards()`, index pagination) must use `Blog::forListing()` — never select `content` / `toc` / `faqs`. Load full HTML only in `post()` / `showData()` for the current article

## SuaveAgent (floating chat)

Site-wide sales chat widget — **not** a contact-page link.

- Layout component: `App\View\Components\Layouts\SuaveAgent` → `resources/views/components/layouts/suave-agent.blade.php` (`<x-layouts.suave-agent />` in `layouts/frontend.blade.php` as a **body-level** sibling of the footer — never inside `.site-footer`, whose `overflow-x: clip` and `content-visibility: auto` capture `position: fixed`). Other page FABs (blog share) use `@push('fixed-widgets')` in the same body-level stack, just above the chat icon.
- Toggle + panel brand mark: `<x-layouts.chat-widget-icon />` (classic circular chat SVG)
- CSS: `public/css/style.css` under `/* ===== SUAVE AGENT CHAT ===== */`
- API: `SuaveAgentController` routes `/suave-agent/start|chat|history` in `routes/web.php`
- Agent: `app/Ai/Agents/SuaveAgent.php` (`gpt-4o-mini`) + tools in `app/Ai/Tools/`
- Knowledge/contacts: `SuaveAgentKnowledge` (offices via `ContactSupport::offices()`, SEO org email/phone)
- Persistence: `ChatLead` + Laravel AI SDK conversation tables only; resume via `localStorage` key `suave_agent_session_v1`
- Assistant replies: Markdown (CDN `marked` in the widget; admin review uses `Str::markdown()` — see suave-admin)
- UX: greet + collect name and phone. Email is optional. The phone input is `<x-frontend.phone-field>` (flag, dial code, national number). Both `chat_leads.email` and `chat_leads.phone` are nullable so either field can be required later without another schema change. The lead form uses `novalidate` and shows a red message under each invalid field (`suave-agent__field-error`) — do not put `required` on those inputs (that shows the browser tooltip). Start is an instant canned greeting; chat streams “Reviewing…” / “Processing…”. Escalate politely via `EscalateToSales`. The homepage consultation can still start a session from one contact value (stored as email or phone, not both).
- Do not point the floating icon at `contact-us`; it opens the chat panel
- The panel auto-opens once per browser tab session, 5 seconds after `window` `load` (`scheduleAutoOpen`). Persistence uses `sessionStorage` key `suave_agent_auto_open_v1` so navigating to other pages does not re-open it. Skip (and mark done) when the visitor already opened or closed the panel, or when `SuaveAgent.open()` / start APIs ran.
- Toggle highlight: white ring plus brand-blue glow (`suave-agent-highlight` on `.suave-agent__toggle`) around the gradient disc so it reads on both the navy hero and light sections. The pulse stops under `prefers-reduced-motion`

## TheSuaveStarPearl (brand emblem)

Animated silver star + pearl mark from the drop-in kit.

- Layout component: `App\View\Components\Layouts\TheSuaveStarPearl` → `resources/views/components/layouts/the-suave-star-pearl.blade.php` (`<x-layouts.the-suave-star-pearl />`)
- Assets: `public/assets/brand/the-suave-metallic-star.webp`, `the-suave-white-pearl.webp`
- JS: `public/js/the-suave-star-pearl.js` (loaded once via `@once` + `@push('scripts')` on the component)
- CSS: `public/css/style.css` under `/* ===== THE SUAVE STAR PEARL ===== */`
- Props: `size`, `decorative`, `ariaLabel`, `starAlt`, `pearlAlt`, `width`/`height`
- Used in Header logo mark
- Do **not** wire star-pearl into `layouts/frontend.blade.php` directly — only via this component

## ChatWidgetIcon (floating chat mark)

Classic circular chat brand mark (brand gradient disc, white mark SVG). The `src` is versioned with `filemtime` because the CDN caches assets as immutable.

- Layout component: `App\View\Components\Layouts\ChatWidgetIcon` → `resources/views/components/layouts/chat-widget-icon.blade.php` (`<x-layouts.chat-widget-icon />`)
- Asset: `public/assets/brand/chat-widget-icon.svg` (PNG variant also available)
- Props: `alt`, `width`, `height`, `src`
- Used by SuaveAgent toggle and panel brand icon

## Company contacts / dual offices

Keep contact details consistent across SEO, footer, contact page, privacy, and SuaveAgent:

- Source of truth: `config/seo.php` organization + `ContactSupport::offices()` / phones
- Homepage JSON-LD (`home` only, `SeoGenerateService::buildHomeJsonLd()`): Organization with the US address, slogan, founding date, founder (`config/seo.php` `organization.founder` — Aakash Choudhary), headcount (`numberOfEmployees.minValue` 10 for “10+”), `sameAs` LinkedIn company + Instagram + Facebook + Crunchbase, and US/UK/Australia `areaServed`; ProfessionalService for the Palampur center (geo `32.0841192`, `76.5132446`); OfferCatalog of live named service routes; WebSite without `SearchAction`; WebPage `#webpage` with `datePublished`/`dateModified` from `seo.pages.home` (2021-01-01 / update day) and `CommunicateAction` to `contact-us`; FAQPage `isPartOf` that webpage. No BreadcrumbList, AggregateRating, or Review nodes. Omit unresolved placeholders (a hire route that is not registered, image files that are not in `public/assets`). Other routes keep the shared graph.
- Marketing `<head>`: `viewport` `initial-scale=1`; default `theme-color` `#0B3D91` from `config/seo.php` via `@yield('theme-color')` (the enterprise AI ERP page yields `#0F172A`); robots `index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1`. Icons: root `favicon.ico` (`sizes="any"`), `assets/brand/favicon-32.png` and `favicon-16.png`, apple touch `favicon-192.png`, and `public/site.webmanifest`. Do not add `favicon.svg` or `public/images/` logo/OG paths. Homepage Open Graph uses `assets/brand/og-default.png` (1200×630) with alt “Suave Creators custom software development team and product dashboard”.
- Offices: United States Headquarters (Sheridan, WY) and India Engineering Center (Palampur, HP)
- Phones: `+1 (307) 435-9605`, `+91 88949 00142`, `+91 18944 55019`
- Email: `info@suavecreators.com`
- When contacts change, update SEO config, ContactSupport, Footer, privacy copy, and `SuaveAgentKnowledge` consumers together
- Contact form phone input: reusable `<x-frontend.phone-field />` (`App\View\Components\Frontend\PhoneField` + `public/js/phone-field.js` + intl-tel-input CDN). Country dial code dropdown with `separateDialCode`; `strictMode` blocks letters; IP country via `route('geo.country')` (CF/CloudFront headers) then `ipapi.co`, fallback `us`. Submit/draft uses the hidden full international number. Allowlisted without `Section` postfix (with `CtaButton` / `CtaArrow` / `HeroCaseStudiesVisual` in `verify-frontend-conventions.ps1`). Inquiry dialogs under `App\View\Components\Frontend\Modal\` (`ContactModal`, `ProjectEstimateModal`, `HireDevelopersModal`, `InquirySelect`) are also non-`Section` helpers (nested folder; not scanned by the flat Frontend allowlist). Site layout renders `<x-frontend.modal.contact-modal />`.

## Assets

- Root: `public/assets/{brand,team,clients,background,hero,blog,portfolio,icons,media,product}/`
- Nested: `blog/blogs-hero`, `icons/tech`
- Files: `asset('assets/...')`; pages: `route()` only
- Logos: `assets/brand/logo-white.webp` (header/footer), `assets/brand/logo.png` (light surfaces)
- **Placement rule:** dedicated folder when it fits; otherwise **`media`**.
- **`clients/`** = real client/partner **company** logos only (e.g. VerySoul, Bioassay). Not tech brands.
- **`icons/tech/`** = tech stack logos/wordmarks (Node.js, React, WordPress, Angular, Vue, PHP, Python, Shopify marks, etc.).
- **`icons/`** = UI/service icons only (filename contains `icon`, or tiny UI marks). Photos/banners/illustrations → `media` (or another dedicated folder).
- **Service capability visuals** (`*-development-icon.svg` with embedded product shots) stay in `icons/`, **not** `icons/tech/`.
- After imports: `scripts/reclassify-assets.ps1` if anything is in the wrong folder.
- After bulk renames: `scripts/rename-assets-by-content.ps1` + `scripts/asset-rename-map.json`.
- **`public/images` must not exist.**
- Do not keep `white_logo.svg` / `gradient-logo.svg` / `logo-white.svg` / `logo.svg` (use `logo-white.webp` / `logo.png`).

### Content naming (required)

Filenames describe the visual — never slot numbers (`tech-dev-1`, `black-logo-7`, `service-mark-logo-3`).

- kebab-case, lowercase, ASCII hyphens; ~3–6 words / under ~60 chars
- No filler: `image`, `photo`, `img`, `banner-1`, `final`, `copy`, `alt` (unless a true second distinct variant)
- **Always confirm brand by rendering/inspecting the asset** — do not guess from design filenames alone
- Known trap: design `black-logo-1.svg` / `black-logo-7.svg` are **Node.js** (identical files), **not** Laravel. Real Laravel color mark is `icons/tech/laravel-color-logo.svg`
- Exact duplicates (same SHA256): keep one canonical file; map old paths to it; delete the duplicate

### Renamed series (do not reintroduce numbered names)

| Design / old pattern | Canonical pattern | Folder |
|----------------------|-------------------|--------|
| `black-logo-*` / `partner-black-logo-*` | brand wordmarks (`nodejs-logo`, `wordpress-logo`, …) | `icons/tech/` |
| `service-logo-*` / `service-mark-logo-*` | color wordmarks (`vue-color-logo`, `php-logo`, …) | `icons/tech/` |
| `com-service-icon-*` / `commerce-service-icon-*` | platform service visuals (`woocommerce-development-icon`, …) | `icons/` |
| `tech-icon-*` / `technology-icon-*` | brand tech icons (`shopify-technology-icon`, …) | `icons/tech/` |
| `tech-dev-*` / `technology-development-icon-*` | stack development visuals (`laravel-development-icon`, …) | `icons/` |

Full old→new tables: [reference.md](reference.md).

### Deduped assets

| Removed duplicate | Kept |
|-------------------|------|
| `laravel-logo-alt.svg` (= former black-logo-7) | `nodejs-logo.svg` (same bytes as black-logo-1/7) |
| `wordpress-logo-alt.svg` (= former black-logo-8) | `wordpress-logo.svg` (same bytes as black-logo-2/8) |

### Helper scripts / maps

| Script / file | Purpose |
|---------------|---------|
| `scripts/organize-assets.ps1` | Flat `public/images/*` → `public/assets/{category}/` |
| `scripts/reclassify-assets.ps1` | Fix misplaced files (`clients`↔`icons/tech`, etc.) |
| `scripts/rename-assets-by-content.ps1` | Apply `asset-rename-map.json` |
| `scripts/rewrite-asset-paths.ps1` | Rewrite `images/...` refs via path map |
| `scripts/asset-path-map.json` | Design + legacy path → current `assets/...` (**runtime** via `MapsDesignAssets`) |
| `scripts/asset-rename-map.json` | Relative rename history for re-runs |
| `scripts/verify-frontend-conventions.ps1` | Fail on convention violations |
| `scripts/audit-frontend.php` | Broken images + internal URL / page status audit (`frontend-audit`) |
| `scripts/audit-img-alts.php` | Alt/title audit against rendered `/` |
| `scripts/build-fa-subset.php` | Regenerate Font Awesome subset CSS when icon usage changes |
| `scripts/split-deferred-css.php` | Move marked sections from `style.css` into `style-deferred.css`. Re-runs **preserve** sections that already live only in the deferred file (including `SINGLE BLOG` so they are not wiped). Current deferred markers include PRODUCT, CRM BUILDER HERO, SINGLE BLOG, and other page-specific blocks. |
| `scripts/generate-product-og-banner.php` | Regenerate product OG banner when hero changes |

When renaming: update both JSON maps, rewrite code refs, then verify. Prefer explicit map entries over heuristic `*-N` prefix rewrites for brand logos.

## Image alt + title (required)

Every `<img>` in Blade must have **non-empty** `alt` and `title` attributes (`title` mirrors `alt`).

Alts must be **SEO-friendly**: natural language that describes the image **and** includes relevant service/brand keywords (software development, CRM, SEO, web design, etc.) — not generic labels like “image”, “icon”, or “team member”.

- 5–12 words when possible; keyword-rich but readable (no stuffing)
- Align with the SEO filename when it matches the visual
- Logos: `{Brand} logo partner of Suave Creators {service keyword}`
- Portraits / team: role + context (`Suave Creators UI UX designer…`, `{Name} client testimonial for Suave Creators…`)
- Service icons: `{Service} service icon` with the product/service name spelled out
- Photos: what is shown + why it matters (`SEO analytics dashboard for search engine optimization services`)
- Decorative duplicates (e.g. marquee clone track): same `alt`/`title`; `aria-hidden="true"` on the wrapper
- After bulk edits, run `php scripts/audit-img-alts.php` — expect `missing_alt=0`, `without_title=0`
- `scripts/verify-frontend-conventions.ps1` fails on missing/empty `alt` or `title`

## SEO file naming

- Patterns: photo `professional-man-navy-blazer-portrait.png`; client `verysoul-logo.png`; service icon `web-development-icon.svg`; background `about-section-bg.png`
- Keep `alt` as a full sentence; filename terse and aligned with the visual
- Never reintroduce `team-1`, `client-logo-4`, `dev-icon-1`, `market-1`, `black-logo-N`, `tech-dev-N` style names

## Section components

| Layer | Pattern |
|-------|---------|
| PHP | `App\View\Components\Frontend\{Name}Section` |
| Blade | `resources/views/components/frontend/{name}-section.blade.php` |
| Tag | `<x-frontend.{name}-section />` |

Shared multi-page blocks must be Section components (not `resources/views/frontend/partials/`). Examples: `tech-partnerships-section`, `partnerships-section`, `core-values-section`, `faq-section`, `testimonials-section`, `articles-insights-section`, `marquee-section`, `consultation-section`, `connect-cta-section`, `industries-section`, `case-studies-carousel-section`, `case-studies-spotlight-section`.

Service / industry page sections: `detail-hero-section` (both; `accent-first` + `eyebrow-class` for industries, `framed-side` for services), `service-intro-section`, `service-overview-section` (hrefs optional → demo link), `service-capabilities-section`, `portfolio-carousel-section` (default slot = inline consultation form), `why-choose-accordion-section`, `process-steps-section`, `industry-intro-section`, `industry-solutions-section`, `industry-specialized-section`, `industry-why-section`, `agile-process-tabs-section`. `core-values-section` renders sector SVG icons when items carry `icon` (`IndustryDetailSupport::sectors()`). Section JS lives in the component via `@once` + `@push('scripts')`.

`connect-cta-section` primary button opens the contact modal by default (`primaryModal = true`); pass `:primary-modal="false"` to use `primary-href` instead. The secondary link defaults to the contact page.

`articles-insights-section` loads the latest three published blogs itself. Pass `category` as a blog category slug, or omit it for the latest posts from any category. Do not pass an `items` array.

**consultation-section vs FAQ:** keep them as separate sections. FAQ uses `<x-frontend.faq-section :show-cta="false" />`; the booking CTA is `<x-frontend.consultation-section />`. The card class is `consultation-card bg-cover bg-no-repeat` plus `bg-top` when `cardPosition` is not `center` (page default is `top`). Empty `people[].src` renders `consultation-person__placeholder` (no broken `<img>`) until portraits land under `assets/team/`. Custom CRM Builder fills all six CTA tiles: `assets/media/analyst-headset-custom-crm-dashboard.webp`, `executive-tablet-crm-hologram.webp`, `floating-analytics-dashboard-laptop.webp`, `analyst-performance-metrics-laptop.webp`, `crm-contact-hologram-keyboard.webp`, and `consultant-crm-team-tablet.webp`. Empty `people[].src` still renders `consultation-person__placeholder`.

Shared CTA chrome: `UiHelper::btnPrimary()` / `UiHelper::ctaArrow()` in `app/Support/Frontend/UiHelper.php`; Blade tags `<x-frontend.cta-button>` and `<x-frontend.cta-arrow />` (do not pass `$btnPrimary` / `$ctaArrow` from controllers). `cta-button` variants: `default` (gradient), `compact`, `secondary` (navy outline pill for light sections), `secondary-dark` (white glass pill for dark sections, e.g. the product page final CTA), `secondary-blue` (blue outline), `secondary-light` (blue-tinted pill for light sections, e.g. `service-overview-section`). Tailwind does not scan `app/Support/Frontend`, so variant styling lives in `style.css` classes, not new utilities. Shared metric count-up chrome: `<x-frontend.case-study-metric-value />` (not a Section) — use it on product story metrics only. Single case-study pages, listing cards, carousels, and spotlight cards show static values (plain `<p>` / `<span>`), not counters.

Name components by **purpose / pattern**, not marketing headline copy (e.g. `connect-cta-section`, not `smart-together-section`).

If the same section markup appears on **more than two pages**, extract a `*Section` component instead of copying Blade.

Layout chrome (`Topbar`, `Header`, `Footer`, `Logo`, `Seo`, `SuaveAgent`, `TheSuaveStarPearl`, `ChatWidgetIcon`) does **not** use `Section`.

## Layout / CSS

- Marketing layout: Tailwind **3.4.17** via Vite (`@vite('resources/css/app.css')`) + Font Awesome subset + `asset('css/style.css')` (+ `style-deferred.css` on non-home pages)
- **Single blog:** Article pages use `og:type` `article`. `BlogSeoService` derives the author (user name, hardcoded job title Founder & Solution Architect, company LinkedIn for `article:author`), featured image, category section, and blog-title breadcrumb (Home → Blog at `route('blogs')` → title). Tags, keywords, about, and mentions come from `blog_seo_details`. JSON-LD adds `BlogPosting` and, when FAQs exist, `FAQPage`, beside the shared Organization and WebSite nodes. CSS lives in `public/css/style-deferred.css` under `/* ===== SINGLE BLOG START/END ===== */` — do not inline a `@push('custom-css')` block in `single-blog.blade.php`. Share widget JS is `public/js/blog-share.js`. Sidebar is Categories + Top Posts only (no More Articles swiper). FAQ chrome title on articles is `Frequently Asked Questions`. Article tables are wrapped in `.blog-table-wrap` (`BlogHtmlSupport::wrapBareTables` on sanitize + render) so they scroll horizontally on mobile instead of clipping. Ancestors of tables (`*:has(> table)` / `*:has(> .blog-table-wrap)`) are capped at `max-width: 100%; min-width: 0` so pasted Google Docs / Tailwind `w-fit` flex wrappers cannot expand past the article and get clipped by `overflow-x: clip`. Stored article outline is H2 → H3 (`BlogHtmlSupport::normalizeArticleHeadings` on save); the page H1 stays in the Blade hero. The page includes `<x-frontend.modal.project-estimate-modal />` and `<x-frontend.modal.hire-developers-modal />`. Article links to `#project-estimate-dialog` and `#hire-developers-dialog` open those dialogs. Pasted typefaces are stripped (`BlogHtmlSupport::stripInlineFonts` on save + render) so copy uses `--site-font`; `.single-blog-content * { font-family: inherit !important }` beats leftover inline `font-family`. On mobile (`max-width: 767px`), blog listing + single-blog heroes/sections override the generic `.site-main>.site-container.relative` padding (`2rem`/`3rem`) so extra top/bottom space is removed — keep those selectors more specific than the hero shell.
- **Security headers:** `App\Http\Middleware\SecurityHeaders` on the web stack. `public/.htaccess` mirrors nosniff / X-Frame-Options / Referrer-Policy / HSTS. CSP **Report-Only** is PHP-only — do not switch to enforcing CSP without reviewing reports
- **Render-blocking:** load those sheets with `media="print" onload="this.media='all'"` (Vite via `Vite::useStyleTagAttributes` when not in HMR). Keep a small inline critical CSS block in `layouts/frontend.blade.php` for the hero LCP shell. Do not reintroduce sync `<link rel="stylesheet">` for those files on the critical path.
- **Site preloader** (`<x-layouts.site-preloader />`): lifts when every `link[data-suave-css]` sheet applies (3s hard cap) — never gate it on `DOMContentLoaded`, which waits for deferred CDN scripts (intl-tel-input). Spinner is inline SVG; `assets/background/loader_bg.webp` is ~12 KB (1920 wide) and versioned with `?v=filemtime` because the CDN serves assets `immutable`. Do not reintroduce a GIF spinner or 4K background, and do not give preloader assets `fetchpriority="high"`
- Swiper CSS/JS: lazy via `frontend-deferred.js` when `.swiper` is near the viewport — not global head links
- Pin `tailwindcss` to `3.4.17` (matches former Play CDN); PostCSS + `tailwind.config.js` — not `@tailwindcss/vite` / v4
- Do not use the Tailwind Play CDN (`cdn.tailwindcss.com`) on marketing pages
- Star-pearl emblem only via `<x-layouts.the-suave-star-pearl />` (not wired into `layouts/frontend.blade.php`)
- Do not set `display` on `.u-touch-target` in CSS (breaks responsive utilities)

## Skill maintenance

Domain skill for marketing frontend. Shared coding lives in `system-coding-standards`; integrity checks in `frontend-audit`. When frontend conventions change, update this skill and `reference.md` in the same change set, then run `orchestration-maintenance`. Do not recreate split skills for CSS/sections/assets.

## Enquiry Analytics

The contact page and CTA popup emit `generate_lead` only for JSON responses with
`success === true` and `lead_tracked === true`. Names are `contact_us` and
`contact_popup`. Keep initialization and pending-submit guards. The popup waits
for the existing Google event callback before redirecting (2s fallback for blocked
tags); never add a thank-you-page lead event or another tag/GTM trigger. Lead
parameters must exclude enquiry fields containing personal information and revenue.
Run `node tests/Browser/enquiry-tracking.mjs` against a local Laravel server on
127.0.0.1:8017 (Chrome installed); responses and Analytics are intercepted. Actual
GA4 delivery needs an approved production test with consent and DebugView.

All public lead-entry forms use distinct `generate_lead` form names:
`contact_us`, `contact_popup`, `project_estimate`, `hire_developers`,
`inline_consultation_form`, and `suave_agent_start`. Estimate/hiring forms share
`inquiry-modals-script`; inline consultation requires explicit success/tracking
flags. Suave Agent's start endpoint instead confirms persistence with the
`conversation_id`, `lead_uuid`, and `session_token` response contract; never send
those identifiers to Analytics. Keep its existing `chat_lead` event alongside
the single `generate_lead`. Restored sessions, inline-to-chat handoffs, and
ongoing chat messages must not emit an additional generate_lead. Search/filter
and admin forms are excluded. All lead handlers need initialization and pending
guards; the chat handler also ignores submissions for an existing session.
