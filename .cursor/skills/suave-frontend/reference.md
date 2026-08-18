# Asset folder map

| Folder | Contents | Example path |
|--------|----------|--------------|
| `brand/` | Site logos, chat widget icons | `assets/brand/logo-white.webp` |
| `team/` | Team photos, consultation portraits, team icons | `assets/team/professional-man-navy-blazer-portrait.png` |
| `clients/` | Real client / partner **company** logos only | `assets/clients/verysoul-logo.png` |
| `background/` | Section backgrounds | `assets/background/about-section-bg.png` |
| `hero/` | Homepage hero stills / pattern assets | `assets/hero/hero-team-brainstorm-overhead.webp` |
| `blog/` | Blog cards, insights | `assets/blog/digital-strategy-collaboration.png` |
| `blog/blogs-hero/` | Blog hero photos | `assets/blog/blogs-hero/01-team.jpg` |
| `portfolio/` | Portfolio / project shots | `assets/portfolio/modern-office-yellow-accent-lounge.png` |
| `icons/` | UI/service icons + `*-development-icon` capability visuals | `assets/icons/web-development-icon.svg` |
| `icons/tech/` | Tech stack logos & wordmarks | `assets/icons/tech/nodejs-logo.svg` |
| `media/` | Fallback — banners, photos, illustrations, process SVGs | `assets/media/seo-infographic-on-imac.png` |
| `product/` | Product page media (stay here; do not reclassify out) | `assets/product/hero-illustration.jpg` |

**Rules:**

- Dedicated folder when it fits; otherwise `media/`.
- Never leave photos/banners in `icons/` (verify requires `icon` in the filename for icons/).
- Tech brands → `icons/tech/`, **not** `clients/`.
- Do not reshuffle `product/`, `portfolio/`, `blog/`, `background/`, `brand/` based on SEO filenames alone.
- Confirm brand by rendering the asset before naming (design `black-logo-*` names are unreliable).

## Current `clients/` (company logos)

- `bioassay-systems-logo.png`
- `verysoul-logo.png`
- `redsixity-logo.svg`
- `dajj-logistics-logo.png`
- `ematrics-logo.png`
- `enterprise-partner-logo-1.svg` … `enterprise-partner-logo-4.svg` (still numbered — rename when brands identified)

## Content rename catalog

### Black / partner tech wordmarks → `icons/tech/`

Design: `/images/black-logo-N.svg` (also staged as `partner-black-logo-N`).

| Old | New | Notes |
|-----|-----|-------|
| `black-logo-1.svg` | `nodejs-logo.svg` | Node.js hexagon + NODE.JS — **not** Laravel |
| `black-logo-2.svg` | `wordpress-logo.svg` | |
| `black-logo-3.svg` | `angular-logo.svg` | |
| `black-logo-4.svg` | `vue-logo.svg` | |
| `black-logo-5.svg` | `wordpress-wordmark-logo.svg` | |
| `black-logo-6.svg` | `react-logo.svg` | |
| `black-logo-7.svg` | `nodejs-logo.svg` | Exact duplicate of #1 — deleted alt copy |
| `black-logo-8.svg` | `wordpress-logo.svg` | Exact duplicate of #2 — deleted alt copy |

Real Laravel color mark (from service logos): `icons/tech/laravel-color-logo.svg`.

### Service mark color logos → `icons/tech/`

Design: `/images/service-logo-N.svg` (was `service-mark-logo-N`).

| Old | New |
|-----|-----|
| `service-logo-1.svg` | `vue-color-logo.svg` |
| `service-logo-2.svg` | `angular-color-logo.svg` |
| `service-logo-3.svg` | `python-logo.svg` |
| `service-logo-4.svg` | `react-color-logo.svg` |
| `service-logo-5.svg` | `laravel-color-logo.svg` |
| `service-logo-6.svg` | `php-logo.svg` |

### Commerce service icons → `icons/`

Design: `/images/com-service-icon-N.svg` (was `commerce-service-icon-N`).

| Old | New | Capability |
|-----|-----|------------|
| `com-service-icon-1.svg` | `woocommerce-development-icon.svg` | WooCommerce |
| `com-service-icon-2.svg` | `shopify-development-icon.svg` | Shopify |
| `com-service-icon-3.svg` | `magento-development-icon.svg` | Magento |
| `com-service-icon-4.svg` | `custom-ecommerce-development-icon.svg` | Custom e-commerce |

### Technology strip icons → `icons/tech/`

Design: `/images/tech-icon-N.png` (was `technology-icon-N.png`).

| Old | New |
|-----|-----|
| `tech-icon-1.png` | `shopify-technology-icon.png` |
| `tech-icon-2.png` | `react-technology-icon.png` |
| `tech-icon-3.png` | `php-technology-icon.png` |
| `tech-icon-4.png` | `nodejs-technology-icon.png` |
| `tech-icon-5.png` | `wordpress-technology-icon.png` |

### Web stack development visuals → `icons/`

Design: `/images/tech-dev-N.svg` (was `technology-development-icon-N.svg`).

| Old | New | Capability |
|-----|-----|------------|
| `tech-dev-1.svg` | `laravel-development-icon.svg` | Laravel |
| `tech-dev-2.svg` | `wordpress-development-icon.svg` | WordPress |
| `tech-dev-3.svg` | `react-development-icon.svg` | ReactJS |
| `tech-dev-4.svg` | `angular-development-icon.svg` | Angular |
| `tech-dev-5.svg` | `php-development-icon.svg` | PHP |
| `tech-dev-6.svg` | `nodejs-development-icon.svg` | Node.js |

## SEO naming examples

| Bad | Good |
|-----|------|
| `team-1.png` | `metallic-s-logo-office-wall.png` |
| `client-logo-4.png` | `verysoul-logo.png` |
| `dev-icon-1.svg` | `web-development-icon.svg` |
| `black-logo-1.svg` | `nodejs-logo.svg` |
| `tech-dev-3.svg` | `react-development-icon.svg` |
| `laravel-logo-alt.svg` | delete if duplicate; else content name |
| `market-1.png` | `seo-infographic-on-imac.png` |
| `background_about.png` | `about-section-bg.png` |

## Import helpers

| Script | Purpose |
|--------|---------|
| `scripts/organize-assets.ps1` | Move flat `public/images/*` into `public/assets/{category}/` |
| `scripts/rewrite-asset-paths.ps1` | Rewrite `images/...` refs to mapped `assets/...` |
| `scripts/reclassify-assets.ps1` | Move misplaced tech logos / icons into the right category |
| `scripts/rename-assets-by-content.ps1` | SEO content-based renames via `asset-rename-map.json` |
| `scripts/import-home.ps1` | Import design home into Blade |
| `scripts/verify-frontend-conventions.ps1` | Fail on convention violations |
| `scripts/asset-path-map.json` | Legacy/design path → current asset path |
| `scripts/asset-rename-map.json` | Relative rename history |

## Blade / PHP examples

```blade
<img src="{{ asset('assets/team/professional-man-navy-blazer-portrait.png') }}" alt="Suave Creators technology leader in a professional setting" title="Suave Creators technology leader in a professional setting" width="56" height="56" loading="lazy" decoding="async">

<img src="{{ asset('assets/icons/tech/nodejs-logo.svg') }}" alt="Node.js technology logo for Suave Creators stack" title="Node.js technology logo for Suave Creators stack" width="69" height="76" loading="lazy" decoding="async">

<section
  {{ $attributes->merge(['class' => 'full-bleed bg-cover bg-top bg-no-repeat']) }}
  @if (filled($backgroundImage)) style="background-image: url('{{ asset($backgroundImage) }}');" @endif
>
```

```php
public string $backgroundImage = 'assets/background/web-services-section-bg.png';
'avatar' => 'assets/team/professional-man-navy-blazer-portrait.png',
'icon' => 'assets/icons/web-development-icon.svg',
'tech' => 'assets/icons/tech/nodejs-logo.svg',
```

## Image alt + title (SEO-friendly)

| Context | Example `alt` / `title` (same value) |
|---------|--------------------------------------|
| Site logo | `Suave Creators logo web and software development company` |
| Client marquee | `VerySoul logo partner of Suave Creators software development` |
| Hero motion GIF | `Custom software and web development work by Suave Creators` |
| Testimonial avatar | `Saurabh Singh Shah client testimonial for Suave Creators web development` |
| Service card photo | `SEO analytics dashboard for search engine optimization services` |
| Service icon | `Search engine optimization SEO service icon` |
| Chat widget | `Chat with Suave Creators for custom software and CRM support` |

Rules: never ship `alt=""` / `title=""`; never omit either. `title` always mirrors `alt`. Prefer keyword-rich natural phrases (service + brand), not generic “image/icon/team member”. Marquee clone rows keep the same text and use `aria-hidden="true"` on the duplicate group.

Audit helper: `php scripts/audit-img-alts.php` against rendered `/`.

## Controllers + named routes

Namespace: `App\Http\Controllers\Frontend\`. Names are **singular**.

| Page | Controller | Named route |
|------|------------|-------------|
| Home | `HomeController@index` | `home` |
| About Us | `AboutController@index` | `about-us` |
| Contact Us | `ContactController@index` | `contact-us` |
| Contact submit | `ContactController@store` | `contact-us.store` |
| Services hub | `ServiceController@index` | `services` |
| Service details (×4) | `ServiceController@show($slug)` | `service.show` |
| Industries hub | `IndustryController@index` | `industries` |
| Industry details (×6) | `IndustryController@show($slug)` | `industry.show` |
| Product | `ProductController@index` | `product` |
| Case study listing | `CaseStudyController@index` | `case-studies` |
| Case study details (static) | `CaseStudyController` dedicated methods | `outreach-case-study`, `ai-sales-coaching-case-study`, `tasks-case-study`, `teerrath-case-study`, `appointment-insurance-case-study`, `cabvi-case-study` |
| Legacy case study slug | `CaseStudyController@show` (301) | `case-study.show` |
| Blog listing | `BlogController@index` | `blogs` |
| Blog posts | `BlogController@show` | `blog.show` |

Page links: `route()` only — never `url('/path')` for internal marketing pages.

## Verification message (required)

When verifying after changes, display to the user:

> The changes are being verified and unwanted file functions are being removed
