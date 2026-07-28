<?php
/**
 * Shared service detail page — full section sequence matching suaveCodebase.
 * Expects $service array from data/services/*.php
 */
if (empty($service) || !is_array($service)) {
  http_response_code(500);
  echo 'Service content missing.';
  return;
}

$h = static function ($v): string {
  return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};

$pageTitle = $service['pageTitle'] ?? 'Services | Suave Creators';
$pageDescription = $service['pageDescription'] ?? '';
$useHeroBackground = true;
require __DIR__ . '/../layout/start.php';

$marqueeIcons = $service['marqueeIcons'] ?? [
  '/images/service-move-1.svg', '/images/service-move-arrow.svg',
  '/images/service-move-2.svg', '/images/service-move-arrow.svg',
  '/images/service-move-3.svg', '/images/service-move-arrow.svg',
  '/images/service-move-4.svg', '/images/service-move-arrow.svg',
];
$portfolioImages = $service['portfolioImages'] ?? [
  '/images/portfolioimg1.webp', '/images/portfolioimg2.webp', '/images/portfolioimg3.webp',
  '/images/portfolioimg4.webp', '/images/portfolioimg5.webp', '/images/portfolioimg6.webp',
];
$blogPosts = is_file(__DIR__ . '/../data/blogs/posts.php') ? require __DIR__ . '/../data/blogs/posts.php' : [];
$latestPosts = array_slice($blogPosts, 0, 3);
$ctaArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>';
$btnPrimary = 'u-btn-cta group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-5 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110';
$bannerBg = $service['bannerBg'] ?? '/images/service-banner-bg.webp';
$webDevLayoutSlugs = [
  'web-development-services',
  'custom-crm-development',
  'e-commerce-development',
  'enterprise-software-solutions',
];
$isWebDevelopmentService = in_array($service['slug'] ?? '', $webDevLayoutSlugs, true);
$capabilitiesAsSlider = !empty($service['capabilitiesAsSlider']);
$capabilitiesGridColumns = (int) ($service['capabilitiesGridColumns'] ?? 3);
$introBg = '/images/web-bg.png';
$collabBackground = $service['collabBackground'] ?? '/images/collab-back.png';
$collabImage = $service['collabImage'] ?? '/images/collab-front.png';
?>

<!-- 1. Hero / Service Banner Section Start -->
<section
  class="full-bleed service-banner relative z-10 bg-cover bg-center bg-no-repeat pt-24 pb-16 md:pt-28 md:pb-20 lg:pt-[100px]"
  style="background-image: url('<?= $h($bannerBg) ?>');"
  aria-labelledby="service-banner-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-12">
      <div class="relative z-0 flex max-w-xl min-w-0 flex-col text-left lg:max-w-[560px]">
        <p class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-sm font-bold uppercase tracking-wide text-transparent"><?= $h($service['eyebrow'] ?? 'Our Services') ?></p>
        <h1 id="service-banner-heading" class="mb-2 mt-2 flex flex-col text-[34px] font-semibold leading-tight text-white min-[375px]:text-[40px] sm:text-5xl sm:leading-none lg:text-[52px]">
          <?php foreach (($service['heroTitle'] ?? []) as $i => $line): ?>
            <?php if ($i === 0): ?>
              <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text font-extrabold text-transparent"><?= $h($line) ?></span>
            <?php else: ?>
              <span><?= $h($line) ?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        </h1>
        <p class="mb-2 mt-2 text-sm leading-6 text-white"><?= $h($service['heroDescription'] ?? '') ?></p>
        <div class="mt-8 mb-6 flex flex-wrap items-center gap-x-4 gap-y-3 sm:mb-0 sm:gap-7">
          <a href="/contact-us/#contact-id" class="u-btn-cta group inline-flex shrink-0 items-center gap-2 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] font-bold whitespace-nowrap text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:px-5 sm:text-sm"><?= $h($service['primaryCta'] ?? "Let's Connect to Discuss") ?><?= $ctaArrow ?></a>
          <a href="/contact-us/#contact-id" class="inline-flex shrink-0 items-center border-b border-white/70 pb-px text-[13px] font-semibold whitespace-nowrap text-white sm:text-sm"><?= $h($service['secondaryCta'] ?? 'Book a Call') ?></a>
        </div>
      </div>
      <div class="relative z-10 hidden w-full min-w-0 items-center justify-center lg:flex lg:justify-end">
        <div class="relative mx-auto flex aspect-square w-full max-w-[420px] items-center justify-center">
          <?php if (!empty($service['heroImage1'])): ?>
            <img src="<?= $h($service['heroImage1']) ?>" alt="" width="480" height="480" class="service-banner__orbit absolute inset-0 z-[1] h-full w-full object-contain" loading="eager" aria-hidden="true">
          <?php endif; ?>
          <?php if (!empty($service['heroImage2'])): ?>
            <img src="<?= $h($service['heroImage2']) ?>" alt="<?= $h($service['pageTitle'] ?? '') ?>" width="160" height="160" class="relative z-[2] w-[32%] max-w-[140px] object-contain drop-shadow-xl" loading="eager">
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php if (!empty($service['bannerLogos'])): ?>
      <div class="service-banner-logos serviceBannerLogosSwiper swiper mt-10 md:mt-12" aria-label="Technologies">
        <div class="swiper-wrapper">
          <?php foreach ($service['bannerLogos'] as $logo): ?>
            <div class="swiper-slide">
              <div class="service-banner-logo">
                <img src="<?= $h($logo['src'] ?? $logo) ?>" alt="<?= $h($logo['alt'] ?? '') ?>" class="service-banner-logo__img" loading="lazy">
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- 1. Hero / Service Banner Section End -->

<!-- 2. Intro + Stats (ProjectProcess) Section Start -->
<section class="full-bleed bg-white bg-[url('<?= $h($introBg) ?>')] bg-cover bg-top bg-no-repeat py-16 lg:py-20" aria-labelledby="service-intro-heading">
  <div class="section-inner">
    <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-14">
      <div>
        <div class="mb-4 flex items-center gap-2">
          <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
          <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['introEyebrow'] ?? 'Our Services') ?></span>
        </div>
        <h2 id="service-intro-heading" class="text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#171717]"><?= $h($service['introTitle'] ?? '') ?></h2>
        <p class="mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]"><?= $h($service['introDescription'] ?? '') ?></p>
        <div class="mt-8">
          <a href="<?= $h($service['introLinkUrl'] ?? '/services') ?>" class="<?= $btnPrimary ?>"><?= $h($service['introLinkText'] ?? 'Explore Services') ?><?= $ctaArrow ?></a>
        </div>
      </div>
      <div class="grid grid-cols-1 gap-3.5 min-[480px]:grid-cols-2">
        <?php
        $stats = [
          ['50+', 'Projects Delivered', 'Successfully completed more than 50+ projects.', '/images/rocket.svg', '#4C24F4'],
          ['10+', 'Years Experience', 'Years of Combined Experience.', '/images/experience.svg', '#1873E7'],
          ['$40M+', 'Funding Secured', 'Helped clients secure more than $40M+ in funding.', '/images/funding.svg', '#0F968E'],
          ['15+', 'Expert Team', '15+ Passionate Developers and Management Teams.', '/images/team.svg', '#FA6811'],
        ];
        foreach ($stats as $stat): ?>
          <article class="flex min-w-0 items-start gap-3.5 rounded-[20px] border border-[rgb(31_38_68_/_3%)] bg-white p-4 shadow-[0_16px_36px_rgb(35_38_91_/_10%)]">
            <img src="<?= $h($stat[3]) ?>" alt="" width="26" height="26" class="h-[26px] w-[26px] shrink-0 object-contain" loading="lazy">
            <div class="min-w-0">
              <strong class="block text-[28px] font-semibold leading-none tracking-tight" style="color: <?= $h($stat[4]) ?>;"><?= $h($stat[0]) ?></strong>
              <h3 class="mt-1 text-[13px] font-semibold leading-none" style="color: <?= $h($stat[4]) ?>;"><?= $h($stat[1]) ?></h3>
              <p class="mt-1 text-[13px] font-medium leading-4 text-[#171717]"><?= $h($stat[2]) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- 2. Intro + Stats Section End -->

<!-- 3. Connect with us Section Start -->
<?php if ($isWebDevelopmentService): ?>
<section class="full-bleed smart-together-cta py-6" aria-labelledby="service-collab-title">
  <div class="smart-together-cta__inner section-inner">
    <div class="smart-together-cta__eyebrow mb-4 flex items-center gap-2">
      <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
      <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">Connect with us</span>
    </div>
    <div class="smart-together-cta__copy">
      <h2 id="service-collab-title">Let’s Build Something Smart Together</h2>
      <p>Ready to transform your ideas into reality with Suave Creators?</p>
    </div>
    <div class="smart-together-cta__actions flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:gap-3">
      <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">
        Get Started
        <?= $ctaArrow ?>
      </a>
      <a href="/contact-us/#contact-id" class="inline-flex max-lg:min-h-[44px] items-end pb-0.5 border-b border-white/70 text-sm font-semibold text-white">Discuss your Vision</a>
    </div>
    <span class="smart-together-cta__phone" aria-hidden="true">
      <img src="/images/phone.gif" alt="" class="rounded-[10px]">
    </span>
  </div>
</section>
<?php endif; ?>
<!-- 3. Connect with us Section End -->

<!-- 4. Service Body (ServiceSection) Start -->
<?php
$bodyImage = $service['bodyImage'] ?? '';
$bodyBg = $service['bodyBg'] ?? '';
$useBodyImageLayout = $bodyImage !== '';
$bodySectionStyle = $useBodyImageLayout
  ? "--service-body-image: url('" . $h($bodyImage) . "');"
  : ($bodyBg !== '' ? "background-image: url('" . $h($bodyBg) . "');" : '');
?>
<section
  class="full-bleed<?= $useBodyImageLayout ? ' full-bleed--edge service-body service-body--webdev' : ($bodyBg !== '' ? ' bg-cover bg-center bg-no-repeat py-16 lg:py-20' : ' bg-white py-16 lg:py-20') ?>"
  <?php if ($bodySectionStyle !== ''): ?>style="<?= $bodySectionStyle ?>"<?php endif; ?>
  aria-labelledby="service-body-heading">
  <div class="<?= $useBodyImageLayout ? 'service-body__inner' : 'section-inner' ?>">
    <div class="<?= $useBodyImageLayout ? 'service-body__content' : 'mx-auto max-w-[1100px] text-center' ?>">
      <?php if ($useBodyImageLayout): ?>
      <div class="mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['bodyEyebrow'] ?? 'Suave Creators') ?></span>
      </div>
      <?php else: ?>
      <p class="offerings-eyebrow mb-4 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['bodyEyebrow'] ?? 'Suave Creators') ?></p>
      <?php endif; ?>
      <h2 id="service-body-heading" class="text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]"><?= $h($service['bodyTitle'] ?? '') ?></h2>
      <?php foreach (($service['bodyParagraphs'] ?? []) as $para): ?>
        <p class="mt-4 text-[14px] leading-6 text-[#4D4D4D]"><?= $h($para) ?></p>
      <?php endforeach; ?>
      <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:gap-5<?= $useBodyImageLayout ? ' items-start sm:items-center' : ' items-center justify-center' ?>">
        <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">Let's Connect to Discuss<?= $ctaArrow ?></a>
        <a href="/contact-us/#contact-id" class="inline-flex max-lg:min-h-[44px] items-end pb-0.5 border-b border-[#00003F] text-sm font-semibold leading-tight text-[#00003F]">Let's Build Your Digital Future Together</a>
      </div>
    </div>
  </div>
</section>
<!-- 4. Service Body Section End -->

<!-- 5. Service Move Marquee Section Start -->
<?php if (!$isWebDevelopmentService): ?>
<section class="full-bleed full-bleed--edge digital-services-marquee digital-services-marquee--white" aria-label="Service capabilities">
  <div class="digital-services-marquee__track">
    <?php for ($g = 0; $g < 2; $g++): ?>
      <div class="digital-services-marquee__group" <?= $g === 1 ? 'aria-hidden="true"' : '' ?>>
        <?php foreach ($marqueeIcons as $icon): ?>
          <span class="digital-services-marquee__icon"><img src="<?= $h($icon) ?>" alt="" loading="lazy" width="40" height="40"></span>
        <?php endforeach; ?>
      </div>
    <?php endfor; ?>
  </div>
</section>
<?php endif; ?>
<!-- 5. Service Move Marquee Section End -->

<!-- 6. Capabilities Section Start -->
<section class="full-bleed web-services<?= $capabilitiesAsSlider ? ' web-services--capabilities-slider' : '' ?> bg-[url('/images/web-bg.png')] bg-cover bg-top bg-no-repeat py-16 lg:py-20" aria-labelledby="service-capabilities-heading">
  <div class="web-services__inner section-inner">
    <header class="web-services__header">
      <div class="mb-4 flex items-center gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['capabilitiesEyebrow'] ?? "Let's Build Together") ?></span>
      </div>
      <div class="web-services__intro">
        <h2 id="service-capabilities-heading" class="mb-4 text-[24px] font-semibold text-[#171717]"><?= $h($service['capabilitiesTitle'] ?? 'Our Expertise') ?></h2>
        <p class="text-[14px] leading-[150%] text-[#4D4D4D]"><?= $h($service['capabilitiesDescription'] ?? '') ?></p>
      </div>
    </header>
    <?php if ($capabilitiesAsSlider): ?>
      <div class="service-capabilities-slider">
        <div class="swiper serviceCapabilitiesSwiper" aria-label="Technologies carousel">
          <div class="swiper-wrapper">
            <?php foreach (($service['capabilities'] ?? []) as $index => $cap): ?>
              <div class="swiper-slide h-auto">
                <article class="web-service-card">
                  <img class="web-service-card__icon-img" src="<?= $h($cap['image'] ?? '') ?>" alt="" width="80" height="64">
                  <div class="web-service-card__category">
                    <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]"><?= $h(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Capability') ?></span>
                    <h3 class="mt-2 text-[14px] font-semibold leading-[130%] text-[#171717]"><?= $h($cap['title'] ?? '') ?></h3>
                  </div>
                  <?php if (!empty($cap['tags'])): ?>
                    <div class="mt-2 flex flex-wrap gap-1.5">
                      <?php foreach ($cap['tags'] as $tag): ?>
                        <span class="rounded-full bg-[#EEF1FF] px-2.5 py-0.5 text-[10px] font-semibold text-[#2A4DFB]"><?= $h($tag) ?></span>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                  <p class="mt-2 text-[14px] text-[#4D4D4D]"><?= $h($cap['desc'] ?? '') ?></p>
                </article>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="service-capabilities-slider__controls">
          <button class="service-capabilities-prev offerings-control" type="button" aria-label="Previous technology">
            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
          </button>
          <button class="service-capabilities-next offerings-control" type="button" aria-label="Next technology">
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    <?php else: ?>
      <div class="web-services__grid<?= $capabilitiesGridColumns === 2 ? ' web-services__grid--cols-2' : '' ?>">
        <?php foreach (($service['capabilities'] ?? []) as $index => $cap): ?>
          <article class="web-service-card">
            <img class="web-service-card__icon-img" src="<?= $h($cap['image'] ?? '') ?>" alt="" width="80" height="64">
            <div class="web-service-card__category">
              <span class="text-[10px] font-semibold uppercase text-[#4D4D4D]"><?= $h(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . ' - Capability') ?></span>
              <h3 class="mt-2 text-[14px] font-semibold leading-[130%] text-[#171717]"><?= $h($cap['title'] ?? '') ?></h3>
            </div>
            <?php if (!empty($cap['tags'])): ?>
              <div class="mt-2 flex flex-wrap gap-1.5">
                <?php foreach ($cap['tags'] as $tag): ?>
                  <span class="rounded-full bg-[#EEF1FF] px-2.5 py-0.5 text-[10px] font-semibold text-[#2A4DFB]"><?= $h($tag) ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <p class="mt-2 text-[14px] text-[#4D4D4D]"><?= $h($cap['desc'] ?? '') ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- 6. Capabilities Section End -->

<!-- 7. Collab Band Section Start -->
<?php if (!$isWebDevelopmentService): ?>
<section
  class="full-bleed collab-section bg-cover bg-center bg-no-repeat py-12 md:py-16"
  style="background-image: url('<?= $h($collabBackground) ?>');"
  aria-labelledby="service-collab-title">
  <div class="section-inner collab-section__inner">
    <div class="collab-section__content">
      <p class="collab-section__message">
        <em><?= $h($service['collabText'] ?? 'Come and build together a better business with') ?></em>
        <strong id="service-collab-title"><?= $h($service['collabBrand'] ?? 'SUAVE CREATORS.') ?></strong>
      </p>
      <a href="/contact-us/#contact-id" class="collab-section__link"><?= $h($service['collabButtonText'] ?? 'REQUEST A QUOTE') ?></a>
    </div>
    <?php if ($collabImage !== ''): ?>
      <div class="collab-section__media">
        <img src="<?= $h($collabImage) ?>" alt="" width="500" height="360" class="collab-section__image" loading="lazy">
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
<!-- 7. Collab Band Section End -->

<!-- 8. Portfolio Showcase Section Start -->
<?php if ($isWebDevelopmentService): ?>
<section class="full-bleed portfolio-showcase portfolio-hero-showcase overflow-hidden bg-[linear-gradient(180deg,#F8FAFF_0%,#FFFFFF_100%)] !py-10 md:!py-14" aria-labelledby="service-portfolio-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['portfolioEyebrow'] ?? 'Our Projects') ?></p>
      <h2 id="service-portfolio-heading" class="mt-4 text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]"><?= $h($service['portfolioTitle'] ?? '') ?></h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]"><?= $h($service['portfolioDescription'] ?? '') ?></p>
    </header>
    <div class="service-portfolio-rail portfolio-hero-rail">
      <div class="swiper servicePortfolioSwiper !overflow-hidden" aria-label="Project showcase carousel">
        <div class="swiper-wrapper">
          <?php foreach ($portfolioImages as $i => $img): ?>
            <div class="swiper-slide h-auto">
              <figure class="portfolio-showcase__image h-full w-full">
                <img src="<?= $h($img) ?>" alt="Suave Creators project showcase <?= $i + 1 ?>" loading="lazy" draggable="false">
              </figure>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="portfolio-hero-pagination"></div>
    <div class="mt-10 flex flex-wrap items-center justify-center gap-5">
      <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">
        Start your Project
        <?= $ctaArrow ?>
      </a>
      <a href="/contact-us/#contact-id" class="border-b border-[#00003F] text-sm font-semibold text-[#00003F]">Book a Call</a>
    </div>
  </div>
</section>
<?php else: ?>
<section class="full-bleed full-bleed--edge portfolio-showcase portfolio-hero-showcase service-portfolio-showcase overflow-hidden bg-[url('/images/portfolio-bg.png')] bg-cover bg-top bg-no-repeat py-16 lg:py-20" aria-labelledby="service-portfolio-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-12">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['portfolioEyebrow'] ?? 'Our Projects') ?></p>
      <h2 id="service-portfolio-heading" class="mt-4 text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]"><?= $h($service['portfolioTitle'] ?? '') ?></h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]"><?= $h($service['portfolioDescription'] ?? '') ?></p>
    </header>
  </div>
  <div class="service-portfolio-rail">
    <div class="swiper servicePortfolioSwiper !overflow-hidden" aria-label="Project showcase carousel">
      <div class="swiper-wrapper">
        <?php foreach ($portfolioImages as $i => $img): ?>
          <div class="swiper-slide h-auto">
            <figure class="portfolio-showcase__image service-portfolio-showcase__image h-full w-full">
              <img src="<?= $h($img) ?>" alt="Project showcase <?= $i + 1 ?>" loading="lazy" draggable="false">
            </figure>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<!-- 8. Portfolio Showcase Section End -->

<!-- 8. Industries We Serve Section Start -->
<section class="full-bleed industries-served bg-[url('/images/industry-bg.png')] bg-cover bg-top bg-no-repeat py-[80px]" aria-labelledby="service-industries-heading">
  <div class="industries-served__inner section-inner">
    <header class="core-values__header">
      <div class="mb-4 flex items-start gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['industriesEyebrow'] ?? 'Industries We Offer') ?></span>
      </div>
      <div class="core-values__heading">
        <h2 id="service-industries-heading"><?= $h($service['industriesTitle'] ?? '') ?></h2>
        <p><?= $h($service['industriesDescription'] ?? '') ?></p>
      </div>
    </header>
    <div class="industries-served__grid">
      <?php foreach (($service['industries'] ?? []) as $ind): ?>
        <a href="<?= $h($ind['link'] ?? '/industry') ?>" class="industry-card">
          <?php if (!empty($ind['icon'])): ?>
            <span class="industry-card__icon inline-flex"><img src="<?= $h($ind['icon']) ?>" alt="" width="26" height="26" class="h-[26px] w-[26px] object-contain" loading="lazy"></span>
          <?php endif; ?>
          <h3><?= $h($ind['title'] ?? '') ?></h3>
          <p><?= $h($ind['desc'] ?? '') ?></p>
          <span class="industry-card__arrow" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 8. Industries We Serve Section End -->

<!-- 9. Technologies & Partnerships Marquee Section Start -->
<?php
$techMarqueeSectionClass = 'full-bleed full-bleed--edge bg-white py-10 lg:py-14';
require __DIR__ . '/tech-partnerships-marquee.php';
?>
<!-- 9. Technologies & Partnerships Marquee Section End -->

<!-- 10. Work With Us CTA Section Start -->
<?php if (!$isWebDevelopmentService): ?>
<section class="full-bleed smart-together-cta py-6" aria-labelledby="service-cta-heading">
  <div class="smart-together-cta__inner section-inner">
    <div class="smart-together-cta__eyebrow mb-4 flex items-center gap-2">
      <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
      <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['ctaEyebrow'] ?? 'Ready to Start Your Project?') ?></span>
    </div>
    <div class="smart-together-cta__copy">
      <h2 id="service-cta-heading" class="text-xl font-semibold leading-none text-white sm:text-2xl"><?= $h($service['ctaTitle'] ?? '') ?></h2>
      <p class="mt-2 text-[11px] font-semibold leading-normal text-[#B1B9DF] sm:text-sm"><?= $h($service['ctaDescription'] ?? '') ?></p>
    </div>
    <div class="smart-together-cta__actions flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:gap-3">
      <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>">Let's Connect to Discuss<?= $ctaArrow ?></a>
      <a href="/contact-us/#contact-id" class="inline-flex max-lg:min-h-[44px] items-end pb-0.5 border-b border-white/70 text-sm font-semibold text-white">Discuss your Vision</a>
    </div>
    <span class="smart-together-cta__phone" aria-hidden="true"><img src="/images/phone.gif" alt="" class="rounded-[10px]"></span>
  </div>
</section>
<?php endif; ?>
<!-- 10. Work With Us CTA Section End -->

<!-- 11. Why Choose Us Section Start -->
<section class="full-bleed overflow-hidden bg-[#F9FAFC] bg-[url('/images/background_offerings.png')] bg-cover bg-top bg-no-repeat py-16 lg:py-20" aria-labelledby="service-why-heading">
  <div class="section-inner">
    <header class="mx-auto mb-10 max-w-[720px] text-center lg:mb-14">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['whyEyebrow'] ?? 'Suave Creators') ?></p>
      <h2 id="service-why-heading" class="mt-4 text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]"><?= $h($service['whyTitle'] ?? '') ?></h2>
      <p class="mx-auto mt-4 max-w-[560px] text-[14px] leading-6 text-[#4D4D4D]"><?= $h($service['whyDescription'] ?? '') ?></p>
    </header>
    <div class="why-choose-list lg:hidden" role="list">
      <?php foreach (($service['whyCards'] ?? []) as $index => $card): ?>
        <?php
          $n = $index + 1;
          $isOpen = $index === 0;
          $whyIndex = str_pad((string) $n, 2, '0', STR_PAD_LEFT);
          $whyTags = array_values(array_filter($card['tags'] ?? [], static fn ($t) => $t !== null && $t !== ''));
          $whyFeatures = array_values(array_filter($card['features'] ?? [], static fn ($f) => $f !== null && $f !== ''));
        ?>
        <article class="why-choose-item<?= $isOpen ? ' is-open' : '' ?>" role="listitem">
          <button
            type="button"
            class="why-choose-item__summary"
            id="service-why-q-<?= $n ?>"
            aria-expanded="<?= $isOpen ? 'true' : 'false' ?>"
            aria-controls="service-why-panel-<?= $n ?>"
          >
            <span class="why-choose-item__top">
              <span class="why-choose-item__index"><?= $h($whyIndex) ?></span>
              <span class="why-choose-item__toggle" aria-hidden="true"></span>
            </span>
            <span class="why-choose-item__title"><?= $h($card['title'] ?? '') ?></span>
            <?php if ($whyTags): ?>
              <span class="why-choose-item__tags"><?= $h(implode(' • ', $whyTags)) ?></span>
            <?php endif; ?>
          </button>
          <div
            class="why-choose-item__panel"
            id="service-why-panel-<?= $n ?>"
            role="region"
            aria-labelledby="service-why-q-<?= $n ?>"
            aria-hidden="<?= $isOpen ? 'false' : 'true' ?>"
          >
            <div class="why-choose-item__panel-inner">
              <?php if (!empty($card['image'])): ?>
                <figure class="why-choose-item__image">
                  <img src="<?= $h($card['image']) ?>" alt="" class="h-full w-full object-cover" width="640" height="400" loading="<?= $isOpen ? 'eager' : 'lazy' ?>">
                </figure>
              <?php endif; ?>
              <?php if (!empty($card['text'])): ?>
                <p class="why-choose-item__text"><?= $h($card['text']) ?></p>
              <?php endif; ?>
              <?php if ($whyFeatures): ?>
                <ul class="why-choose-item__features">
                  <?php foreach ($whyFeatures as $feature): ?>
                    <li><?= $h($feature) ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="hidden grid-cols-1 gap-5 sm:grid-cols-2 lg:grid lg:grid-cols-3 lg:gap-6">
      <?php foreach (($service['whyCards'] ?? []) as $card): ?>
        <article class="flex min-h-full flex-col gap-3 overflow-hidden rounded-[22px] border border-[rgba(42,77,251,0.08)] bg-white shadow-[0_18px_40px_rgba(36,36,84,0.06)]">
          <?php if (!empty($card['image'])): ?>
            <figure class="aspect-[16/10] overflow-hidden"><img src="<?= $h($card['image']) ?>" alt="" class="h-full w-full object-cover" loading="lazy"></figure>
          <?php endif; ?>
          <div class="flex flex-1 flex-col gap-3 p-[22px]">
            <h3 class="text-base font-bold leading-tight text-[#171717]"><?= $h($card['title'] ?? '') ?></h3>
            <p class="flex-1 text-sm leading-relaxed text-[#4D4D4D]"><?= $h($card['text'] ?? '') ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="mt-10 flex justify-center">
      <a href="/contact-us/#contact-id" class="<?= $btnPrimary ?>"><?= $h($service['whyButtonText'] ?? "Let's Discuss Your Vision") ?><?= $ctaArrow ?></a>
    </div>
  </div>
</section>
<!-- 11. Why Choose Us Section End -->

<!-- 12. Development Process Section Start -->
<section class="full-bleed development-process-section<?= $isWebDevelopmentService ? ' development-process-section--webdev' : '' ?>" aria-labelledby="service-process-heading">
  <div class="section-inner">
    <header class="development-process-section__header">
      <p class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['processEyebrow'] ?? 'Suave Creators') ?></p>
      <h2 id="service-process-heading" class="development-process-section__title"><?= $h($service['processTitle'] ?? '') ?></h2>
      <p class="development-process-section__description font-sans"><?= $h($service['processDescription'] ?? '') ?></p>
    </header>
    <div class="development-process-section__inner">
      <div class="development-process-section__steps">
        <?php
        $defaultProcessIcons = [
          '/images/industry-discovery-strategy.svg',
          '/images/industry-design-development.svg',
          '/images/industry-goals.svg',
          '/images/industry-multi-channel-communication.svg',
          '/images/industry-launch-growth.svg',
        ];
        foreach (($service['processSteps'] ?? []) as $index => $step):
          $stepNumber = $step['step'] ?? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
          $stepIcon = $step['icon'] ?? $defaultProcessIcons[$index % count($defaultProcessIcons)];
        ?>
          <article class="development-process-section__step">
            <div class="development-process-section__step-top">
              <span class="development-process-section__step-icon">
                <img src="<?= $h($stepIcon) ?>" alt="" width="28" height="28" loading="lazy">
              </span>
              <span class="development-process-section__step-number" aria-hidden="true"><?= $h($stepNumber) ?></span>
            </div>
            <h3 class="development-process-section__step-title"><?= $h($step['title'] ?? '') ?></h3>
            <p class="development-process-section__step-text"><?= $h($step['desc'] ?? '') ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- 12. Development Process Section End -->

<!-- 13. Stand Out / Process Cards Section Start -->
<section class="full-bleed industries-served bg-[url('/images/industry-bg.png')] py-[80px] bg-cover bg-top bg-no-repeat" aria-labelledby="service-standout-heading">
  <div class="industries-served__inner section-inner">
    <header class="core-values__header">
      <div class="mb-4 flex items-start gap-2">
        <span class="inline-block h-[16px] w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent"><?= $h($service['standoutEyebrow'] ?? 'Why Suave Creators Stands Out') ?></span>
      </div>
      <div class="core-values__heading">
        <h2 id="service-standout-heading"><?= $h($service['standoutTitle'] ?? '') ?></h2>
        <?php if (!empty($service['standoutDescription'])): ?>
          <p><?= $h($service['standoutDescription']) ?></p>
        <?php endif; ?>
      </div>
    </header>
    <div class="industries-served__grid">
      <?php foreach (($service['standoutCards'] ?? []) as $card): ?>
        <article class="industry-card industry-card--standout">
          <div class="industry-card__top">
            <?php if (!empty($card['icon'])): ?>
              <span class="industry-card__icon inline-flex"><img src="<?= $h($card['icon']) ?>" alt="" width="28" height="28" class="h-7 w-7 object-contain" loading="lazy"></span>
            <?php endif; ?>
            <?php if (!empty($card['step'])): ?>
              <span class="industry-card__step bg-[linear-gradient(180deg,#2f69fb_12%,#c56bff_100%)] bg-clip-text text-[22px] font-extrabold text-transparent" aria-hidden="true"><?= $h($card['step']) ?></span>
            <?php endif; ?>
          </div>
          <h3><?= $h($card['title'] ?? '') ?></h3>
          <p><?= $h($card['desc'] ?? '') ?></p>
          <?php if (empty($card['step'])): ?>
            <span class="industry-card__arrow" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8L22 12L18 16"></path>
                <path d="M2 12H22"></path>
              </svg>
            </span>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 13. Stand Out Section End -->

<!-- 14. Logo Shape Marquee Section Start -->
<?php if (!$isWebDevelopmentService): ?>
<section class="full-bleed full-bleed--edge digital-services-marquee digital-services-marquee--white" aria-label="Brand marks">
  <div class="digital-services-marquee__track">
    <?php for ($g = 0; $g < 2; $g++): ?>
      <div class="digital-services-marquee__group" <?= $g === 1 ? 'aria-hidden="true"' : '' ?>>
        <?php for ($i = 0; $i < 8; $i++): ?>
          <span class="digital-services-marquee__icon"><img src="/images/logo-shape.svg" alt="" loading="lazy" width="40" height="40"></span>
        <?php endfor; ?>
      </div>
    <?php endfor; ?>
  </div>
</section>
<?php endif; ?>
<!-- 14. Logo Shape Marquee Section End -->

<!-- 15. FAQ Section Start -->
<section class="full-bleed faq-section faq-section--align faq-section--desktop-media" aria-labelledby="service-faq-heading">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      <p class="faq-section__eyebrow flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">Have questions about our Services?</span>
      </p>
      <h2 id="service-faq-heading" class="mt-3 text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#171717]">Frequently Ask Question</h2>
      <p class="faq-section__description mt-3 text-sm leading-6 text-[#4D4D4D]">Here are the most asked questions for this service.</p>
      <?php require __DIR__ . '/faq-cta-button.php'; ?>
      <img class="faq-section__image" src="/images/faq-gif.gif" alt="" width="640" height="960" loading="lazy">
    </div>
    <div class="faq-list">
      <?php foreach (($service['faqs'] ?? []) as $index => $faq): ?>
        <?php $n = $index + 1; ?>
        <div class="faq-item<?= $index === 0 ? ' is-open' : '' ?>">
          <button type="button" class="faq-item__summary" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="service-faq-<?= $n ?>" id="service-faq-q-<?= $n ?>">
            <span><?= $h($faq['question'] ?? '') ?></span>
            <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
          </button>
          <div class="faq-item__answer" id="service-faq-<?= $n ?>" role="region" aria-labelledby="service-faq-q-<?= $n ?>" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
            <div class="faq-item__answer-inner"><p><?= $h($faq['answer'] ?? '') ?></p></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- 15. FAQ Section End -->

<!-- 16. Final Hero CTA Section Start -->
<?php
  $finalBg = $service['finalBg'] ?? ($service['bannerBg'] ?? '/images/webservice-bg.webp');
  $hideFinalBgBelowDesktop = ($service['hideFinalBgBelowDesktop'] ?? false) === true;
  $consultationCardClass = 'consultation-card bg-cover bg-top bg-no-repeat';
  if ($hideFinalBgBelowDesktop) {
    $consultationCardClass .= ' consultation-card--hide-bg-below-desktop';
  } else {
    $consultationCardClass .= ' bg-[url(\'' . $finalBg . '\')]';
  }
?>
<section id="consultation" class="full-bleed consultation-section">
  <div class="section-inner">
    <div
      class="<?= $h($consultationCardClass) ?>"
      <?php if ($hideFinalBgBelowDesktop): ?>style="--consultation-bg: url('<?= $h($finalBg) ?>')"<?php endif; ?>
    >
      <div class="consultation-copy">
        <p class="mb-2 text-sm font-bold uppercase tracking-wide text-white/70"><?= $h($service['finalEyebrow'] ?? 'Your Digital Future Together') ?></p>
        <h2><?= $h($service['finalTitle'] ?? "Let's Build Your Business Website Together") ?></h2>
        <p><?= $h($service['finalDescription'] ?? '') ?></p>
        <div class="flex flex-wrap gap-4">
          <a href="/contact-us/#contact-id" class="consultation-cta"><?= $h($service['finalPrimaryCta'] ?? 'Get a Free Quote') ?> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
          <a href="/contact-us/#contact-id" class="consultation-secondary-link inline-flex items-end pb-0.5 border-b border-white/70 text-sm font-semibold text-white"><?= $h($service['finalSecondaryCta'] ?? 'Contact us Today') ?></a>
        </div>
      </div>
      <?php if (($service['showFinalPeople'] ?? true) !== false): ?>
      <div class="consultation-people">
        <div class="consultation-people__column consultation-people__column--left">
          <figure class="consultation-person consultation-person--pink"><img src="/images/consult-1.png" alt="" width="640" height="960" loading="lazy"></figure>
          <figure class="consultation-person consultation-person--orange"><img src="/images/consult-2.png" alt="" width="640" height="960" loading="lazy"></figure>
        </div>
        <div class="consultation-people__column">
          <figure class="consultation-person consultation-person--yellow"><img src="/images/consult-3.png" alt="" width="640" height="960" loading="lazy"></figure>
          <figure class="consultation-person consultation-person--blue"><img src="/images/consult-4.png" alt="" width="640" height="960" loading="lazy"></figure>
        </div>
        <div class="consultation-people__column consultation-people__column--right">
          <figure class="consultation-person consultation-person--coral"><img src="/images/consult-5.png" alt="" width="640" height="959" loading="lazy"></figure>
          <figure class="consultation-person consultation-person--cyan"><img src="/images/consult-6.png" alt="" width="640" height="960" loading="lazy"></figure>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<!-- 16. Final Hero CTA Section End -->

<?php
$articlesInsightsItems = [];
if (!empty($latestPosts)) {
  foreach ($latestPosts as $post) {
    $articlesInsightsItems[] = [
      'title' => $post['title'] ?? '',
      'excerpt' => $post['short_description'] ?? ($post['excerpt'] ?? ($post['description'] ?? '')),
      'image' => $post['image'] ?? '/images/blog-1.png',
      'alt' => $post['title'] ?? '',
      'date' => $post['published_label'] ?? ($post['date'] ?? ''),
      'datetime' => $post['published_date'] ?? ($post['datetime'] ?? ''),
      'author' => $post['author_name'] ?? 'Suave Creators',
      'url' => '/blog/' . ($post['slug'] ?? ''),
    ];
  }
} else {
  $articlesInsightsItems = [
    [
      'title' => 'How to Build a Digital Strategy That Creates Real Business Value',
      'excerpt' => 'A practical framework for connecting customer needs and measurable growth.',
      'image' => '/images/blog-1.png',
      'alt' => 'How to Build a Digital Strategy That Creates Real Business Value',
      'date' => 'Jun 24, 2026',
      'datetime' => '2026-06-24',
      'author' => 'Suave Creators',
      'url' => '/blog/digital-strategy-that-creates-value',
    ],
    [
      'title' => 'Turning Product Data into Better Customer Experiences',
      'excerpt' => 'Focused analytics that reveal friction and improve the user journey.',
      'image' => '/images/blog-2.png',
      'alt' => 'Turning Product Data into Better Customer Experiences',
      'date' => 'Jun 12, 2026',
      'datetime' => '2026-06-12',
      'author' => 'Suave Creators',
      'url' => '/blog/product-data-customer-experiences',
    ],
    [
      'title' => 'Designing Digital Workflows Your Team Will Actually Use',
      'excerpt' => 'Principles for connected tools that reduce busywork.',
      'image' => '/images/blog-3.png',
      'alt' => 'Designing Digital Workflows Your Team Will Actually Use',
      'date' => 'May 29, 2026',
      'datetime' => '2026-05-29',
      'author' => 'Suave Creators',
      'url' => '/blog/digital-workflows-teams-use',
    ],
  ];
}
$articlesInsightsHeadingId = 'service-insights-title';
$articlesInsightsTitle = 'Explore Our Insights';
$articlesInsightsSubtitle = 'Get in touch with industry trends with our updated blogs from technology and development experts.';
$articlesInsightsSectionClass = 'py-16 lg:py-18';
$articlesInsightsMoreHref = '/blogs';
$articlesInsightsMoreLabel = 'View More';
require __DIR__ . '/articles-insights.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  if (typeof Swiper !== 'undefined' && document.querySelector('.servicePortfolioSwiper')) {
    var isIndustryStylePortfolio = !!document.querySelector('.portfolio-hero-rail .servicePortfolioSwiper');
    var portfolioMarqueeSpeed = 18000;
    var portfolioDragSpeed = 500;
    new Swiper('.servicePortfolioSwiper', isIndustryStylePortfolio
      ? {
          slidesPerView: 1,
          spaceBetween: 16,
          speed: 700,
          rewind: true,
          allowTouchMove: true,
          simulateTouch: true,
          grabCursor: true,
          touchEventsTarget: 'container',
          touchStartPreventDefault: false,
          watchOverflow: true,
          autoplay: reduce.matches
            ? false
            : { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true },
          pagination: {
            el: '.portfolio-hero-pagination',
            clickable: true
          },
          a11y: {
            enabled: true,
            containerMessage: 'Project showcase carousel'
          },
          breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 18 },
            1024: { slidesPerView: 4, spaceBetween: 20 }
          }
        }
      : {
          slidesPerView: 1.15,
          spaceBetween: 16,
          speed: portfolioMarqueeSpeed,
          loop: true,
          loopAdditionalSlides: 4,
          allowTouchMove: true,
          simulateTouch: true,
          grabCursor: true,
          touchEventsTarget: 'container',
          touchStartPreventDefault: false,
          watchSlidesProgress: true,
          watchOverflow: true,
          autoplay: reduce.matches
            ? false
            : { delay: 0, disableOnInteraction: false, pauseOnMouseEnter: true },
          a11y: {
            enabled: true,
            containerMessage: 'Project showcase carousel'
          },
          breakpoints: {
            640: { slidesPerView: 2.2, spaceBetween: 18 },
            1024: { slidesPerView: 3.2, spaceBetween: 22 },
            1400: { slidesPerView: 3.8, spaceBetween: 24 }
          },
          on: {
            touchStart: function (swiper) {
              swiper.params.speed = portfolioDragSpeed;
              if (swiper.autoplay && swiper.autoplay.running) {
                swiper.autoplay.stop();
              }
            },
            touchEnd: function (swiper) {
              swiper.params.speed = portfolioMarqueeSpeed;
              if (!reduce.matches && swiper.params.autoplay && swiper.autoplay) {
                swiper.autoplay.start();
              }
            }
          }
        });
  }

  if (typeof Swiper !== 'undefined' && document.querySelector('.serviceCapabilitiesSwiper')) {
    new Swiper('.serviceCapabilitiesSwiper', {
      slidesPerView: 1,
      spaceBetween: 16,
      speed: 650,
      rewind: true,
      watchOverflow: true,
      navigation: {
        nextEl: '.service-capabilities-next',
        prevEl: '.service-capabilities-prev'
      },
      a11y: {
        enabled: true,
        containerMessage: 'Technologies carousel'
      },
      breakpoints: {
        768: { slidesPerView: 2, spaceBetween: 18 },
        1024: { slidesPerView: 3, spaceBetween: 20 }
      }
    });
  }

  var bannerLogosEl = document.querySelector('.serviceBannerLogosSwiper');
  if (typeof Swiper !== 'undefined' && bannerLogosEl) {
    var bannerLogosMq = window.matchMedia('(max-width: 1023px)');
    var bannerLogosSwiper = null;

    function syncBannerLogosSwiper() {
      if (bannerLogosMq.matches) {
        if (bannerLogosSwiper) return;
        bannerLogosSwiper = new Swiper(bannerLogosEl, {
          slidesPerView: 2,
          spaceBetween: 10,
          speed: 500,
          loop: true,
          watchOverflow: true,
          allowTouchMove: true,
          autoplay: reduce.matches
            ? false
            : { delay: 2000, disableOnInteraction: false, pauseOnMouseEnter: true },
          a11y: {
            enabled: true,
            containerMessage: 'Technologies carousel'
          },
          breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 16 }
          }
        });
        return;
      }

      if (bannerLogosSwiper) {
        bannerLogosSwiper.destroy(true, true);
        bannerLogosSwiper = null;
      }
    }

    syncBannerLogosSwiper();
    if (typeof bannerLogosMq.addEventListener === 'function') {
      bannerLogosMq.addEventListener('change', syncBannerLogosSwiper);
    } else if (typeof bannerLogosMq.addListener === 'function') {
      bannerLogosMq.addListener(syncBannerLogosSwiper);
    }
  }

  var faqItems = document.querySelectorAll('.faq-list .faq-item');
  function setAria(item, open) {
    item.querySelector('.faq-item__summary').setAttribute('aria-expanded', open ? 'true' : 'false');
    item.querySelector('.faq-item__answer').setAttribute('aria-hidden', open ? 'false' : 'true');
  }
  function openFaq(item) {
    var a = item.querySelector('.faq-item__answer');
    item.classList.add('is-open'); setAria(item, true);
    if (reduce.matches) { a.style.height = 'auto'; return; }
    a.style.height = a.getBoundingClientRect().height + 'px'; a.offsetHeight;
    a.style.height = a.scrollHeight + 'px';
    a.addEventListener('transitionend', function once(e) {
      if (e.propertyName === 'height' && item.classList.contains('is-open')) { a.style.height = 'auto'; a.removeEventListener('transitionend', once); }
    });
  }
  function closeFaq(item) {
    var a = item.querySelector('.faq-item__answer');
    if (reduce.matches) { item.classList.remove('is-open'); setAria(item, false); a.style.height = '0px'; return; }
    a.style.height = (a.style.height === 'auto' ? a.scrollHeight : a.getBoundingClientRect().height) + 'px';
    a.offsetHeight; item.classList.remove('is-open'); setAria(item, false);
    requestAnimationFrame(function () { a.style.height = '0px'; });
  }
  faqItems.forEach(function (item) {
    var a = item.querySelector('.faq-item__answer');
    var open = item.classList.contains('is-open');
    a.style.transition = 'none'; a.style.height = open ? 'auto' : '0px'; setAria(item, open);
  });
  if (faqItems.length) faqItems[0].offsetHeight;
  faqItems.forEach(function (item) {
    var a = item.querySelector('.faq-item__answer');
    a.style.removeProperty('transition');
    item.querySelector('.faq-item__summary').addEventListener('click', function () {
      var should = !item.classList.contains('is-open');
      faqItems.forEach(function (s) { if (s !== item && s.classList.contains('is-open')) closeFaq(s); });
      if (should) openFaq(item); else closeFaq(item);
    });
  });

  var whyItems = document.querySelectorAll('.why-choose-list .why-choose-item');
  function setWhyAria(item, open) {
    item.querySelector('.why-choose-item__summary').setAttribute('aria-expanded', open ? 'true' : 'false');
    item.querySelector('.why-choose-item__panel').setAttribute('aria-hidden', open ? 'false' : 'true');
  }
  function openWhy(item) {
    var panel = item.querySelector('.why-choose-item__panel');
    item.classList.add('is-open');
    setWhyAria(item, true);
    if (reduce.matches) { panel.style.height = 'auto'; return; }
    panel.style.height = panel.getBoundingClientRect().height + 'px';
    panel.offsetHeight;
    panel.style.height = panel.scrollHeight + 'px';
    panel.addEventListener('transitionend', function once(e) {
      if (e.propertyName === 'height' && item.classList.contains('is-open')) {
        panel.style.height = 'auto';
        panel.removeEventListener('transitionend', once);
      }
    });
  }
  function closeWhy(item) {
    var panel = item.querySelector('.why-choose-item__panel');
    if (reduce.matches) {
      item.classList.remove('is-open');
      setWhyAria(item, false);
      panel.style.height = '0px';
      return;
    }
    panel.style.height = (panel.style.height === 'auto' ? panel.scrollHeight : panel.getBoundingClientRect().height) + 'px';
    panel.offsetHeight;
    item.classList.remove('is-open');
    setWhyAria(item, false);
    requestAnimationFrame(function () { panel.style.height = '0px'; });
  }
  whyItems.forEach(function (item) {
    var panel = item.querySelector('.why-choose-item__panel');
    var open = item.classList.contains('is-open');
    panel.style.transition = 'none';
    panel.style.height = open ? 'auto' : '0px';
    setWhyAria(item, open);
  });
  if (whyItems.length) whyItems[0].offsetHeight;
  whyItems.forEach(function (item) {
    var panel = item.querySelector('.why-choose-item__panel');
    panel.style.removeProperty('transition');
    item.querySelector('.why-choose-item__summary').addEventListener('click', function () {
      var should = !item.classList.contains('is-open');
      whyItems.forEach(function (sibling) {
        if (sibling !== item && sibling.classList.contains('is-open')) closeWhy(sibling);
      });
      if (should) openWhy(item); else closeWhy(item);
    });
  });
});
</script>

<style>
.web-services__grid--cols-2 {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.web-service-card__icon-img {
  display: block;
  height: 64px;
  margin-bottom: 14px;
  min-width: 80px;
  object-fit: contain;
  width: 80px;
}

.why-choose-list {
  display: grid;
  gap: 14px;
  margin-inline: auto;
  max-width: 820px;
}

@media (min-width: 1024px) {
  .why-choose-list {
    display: none;
  }
}

.why-choose-item {
  background: #fff;
  border: 1px solid rgba(42, 77, 251, 0.08);
  border-radius: 18px;
  box-shadow: 0 18px 40px rgba(36, 36, 84, 0.06);
  overflow: hidden;
  transition: box-shadow 180ms ease;
}

.why-choose-item__summary {
  align-items: stretch;
  background: transparent;
  border: 0;
  color: inherit;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  font-family: inherit;
  gap: 6px;
  padding: 18px 20px;
  text-align: left;
  width: 100%;
}

.why-choose-item__summary:focus-visible {
  outline: 2px solid #2a4dfb;
  outline-offset: -2px;
}

.why-choose-item__top {
  align-items: center;
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.why-choose-item__index {
  color: #6b7280;
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 0.04em;
  line-height: 1;
}

.why-choose-item__toggle {
  color: #171717;
  flex: 0 0 auto;
  font-size: 22px;
  font-weight: 400;
  line-height: 1;
  position: relative;
  width: 1em;
  height: 1em;
}

.why-choose-item__toggle::before,
.why-choose-item__toggle::after {
  background: currentColor;
  content: "";
  left: 50%;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  transition: opacity 180ms ease, transform 180ms ease;
}

.why-choose-item__toggle::before {
  height: 2px;
  width: 14px;
}

.why-choose-item__toggle::after {
  height: 14px;
  width: 2px;
}

.why-choose-item__title {
  color: #171717;
  display: block;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.35;
  padding-right: 28px;
}

.why-choose-item__tags {
  color: #6b7280;
  display: block;
  font-size: 13px;
  font-weight: 500;
  line-height: 1.45;
  padding-right: 28px;
}

.why-choose-item__panel {
  height: 0;
  opacity: 0;
  overflow: hidden;
  transition: height 280ms ease, opacity 220ms ease;
}

.why-choose-item__panel-inner {
  border-top: 1px solid rgba(23, 23, 23, 0.08);
  display: grid;
  gap: 16px;
  margin: 0 20px;
  padding: 18px 0 20px;
}

.why-choose-item__image {
  aspect-ratio: 16 / 10;
  border-radius: 12px;
  margin: 0;
  overflow: hidden;
}

.why-choose-item__image img {
  display: block;
  height: 100%;
  object-fit: cover;
  width: 100%;
}

.why-choose-item__text {
  color: #4d4d4d;
  font-size: 14px;
  line-height: 1.65;
  margin: 0;
}

.why-choose-item__features {
  display: grid;
  gap: 10px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.why-choose-item__features li {
  align-items: flex-start;
  color: #171717;
  display: flex;
  font-size: 14px;
  font-weight: 500;
  gap: 10px;
  line-height: 1.45;
}

.why-choose-item__features li::before {
  background: transparent;
  border: 1.5px solid #2a4dfb;
  border-radius: 50%;
  content: "";
  flex: 0 0 auto;
  height: 10px;
  margin-top: 4px;
  width: 10px;
}

.service-capabilities-slider {
  min-width: 0;
}

.serviceCapabilitiesSwiper {
  overflow: hidden;
}

.service-capabilities-slider__controls {
  display: flex;
  gap: 8px;
  justify-content: flex-end;
  margin-top: 24px;
}

.service-body--webdev {
  background-color: #efeef1;
  background-image: var(--service-body-image);
  background-position: left center;
  background-repeat: no-repeat;
  background-size: cover;
  min-height: min(100vh, 820px);
  overflow: hidden;
  padding-block: 60px;
  position: relative;
}

.digital-services-marquee--white {
  background: #ffffff;
}

.collab-section {
  color: #fff;
}

.collab-section__inner {
  align-items: center;
  display: flex;
  gap: 40px;
  justify-content: space-between;
}

.collab-section__content {
  flex: 0 1 60%;
  max-width: 720px;
}

.collab-section__message {
  color: #fff;
  font-family: Georgia, "Times New Roman", serif;
  font-size: clamp(1.125rem, 2.2vw, 1.5rem);
  font-style: normal;
  line-height: 1.6;
  margin: 0;
}

.collab-section__message em {
  font-style: italic;
  font-weight: 400;
}

.collab-section__message strong {
  color: #fff;
  display: block;
  font-style: normal;
  font-weight: 700;
  margin-top: 0.35rem;
}

.collab-section__link {
  color: #6c63ff;
  display: inline-block;
  font-size: 16px;
  font-style: normal;
  font-weight: 700;
  margin-top: 10px;
  text-decoration: underline;
  text-transform: uppercase;
}

.collab-section__link:hover {
  color: #8b84ff;
}

.collab-section__link:focus-visible {
  outline: 2px solid #fff;
  outline-offset: 3px;
}

.collab-section__media {
  display: flex;
  flex: 1 1 40%;
  justify-content: center;
  min-width: 0;
}

.collab-section__image {
  border-radius: 10px;
  display: block;
  height: auto;
  max-width: 500px;
  object-fit: cover;
  width: 100%;
}

.service-portfolio-rail {
  margin-top: 0;
  min-width: 0;
  width: 100%;
}

.service-portfolio-showcase .servicePortfolioSwiper {
  overflow: hidden;
  width: 100%;
}

.service-portfolio-showcase .service-portfolio-showcase__image {
  aspect-ratio: auto;
  border-radius: 12px;
  height: clamp(280px, 42vw, 520px);
  box-shadow: 0 16px 36px rgb(36 36 84 / 10%);
}

.service-portfolio-showcase .service-portfolio-showcase__image img {
  height: 100%;
  object-fit: cover;
  width: 100%;
}

.service-banner-logos {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
  width: 100%;
  max-width: 100%;
  overflow: hidden;
}

@media (min-width: 1024px) {
  .service-banner-logos {
    overflow: visible;
    padding: 10px;
    margin: -10px;
    width: calc(100% + 20px);
    max-width: none;
  }
}

.service-banner__orbit {
  animation: service-banner-orbit 13s linear infinite;
}

.service-banner-logo {
  position: relative;
  isolation: isolate;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  min-width: 0;
  min-height: 88px;
  padding: 14px 10px;
  border-radius: 16px;
  overflow: hidden;
  background: radial-gradient(
  90.16% 143.01% at 15.32% 21.04%,
  rgba(165, 239, 255, 0.2) 0%,
  rgba(110, 191, 244, 0.05) 77.08%,
  rgba(70, 144, 213, 0) 100%
  );
  backdrop-filter: blur(80px);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  z-index: 1;
}

@media (min-width: 640px) {
  .service-banner-logo {
    min-height: 96px;
    padding: 16px 12px;
  }
}

.service-banner-logo::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: inherit;
  padding: 2px;
  background: linear-gradient(270deg, #98f9ff, #eabfff, #8726b7, #98f9ff);
  background-size: 400% 400%;
  animation: serviceBannerLogoGradient 8s linear infinite;
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  mask-composite: exclude;
  -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  pointer-events: none;
  z-index: 0;
}

.service-banner-logo:hover {
  z-index: 2;
  transform: scale(1.05);
  box-shadow: 0 0 25px rgba(152, 249, 255, 0.3),
  0 0 50px rgba(234, 191, 255, 0.15);
}

.service-banner-logo__img {
  position: relative;
  z-index: 1;
  max-width: 88px;
  max-height: 52px;
  width: auto;
  height: auto;
  object-fit: contain;
  opacity: 0.9;
  transition: opacity 0.3s ease;
}

.service-banner-logo:hover .service-banner-logo__img {
  opacity: 1;
}

.development-process-section {
  background: linear-gradient(5deg, #edf0ff 0%, #ffffff 100%);
  padding: 80px 0;
  text-align: center;
}

.development-process-section__header {
  align-items: center;
  display: flex;
  flex-direction: column;
  margin: 0 auto 32px;
  max-width: 720px;
  text-align: center;
  width: 100%;
}

.development-process-section__title {
  color: #171717;
  font-size: clamp(1.75rem, 4vw, 2.75rem);
  font-weight: 600;
  line-height: 1.2;
  margin: 16px auto 0;
  max-width: 680px;
  text-align: center;
}

.development-process-section__description {
  color: #4d4d4d;
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-size: 14px;
  line-height: 1.5;
  margin: 16px auto 0;
  max-width: 700px;
  text-align: center;
  width: 100%;
}

.development-process-section__inner {
  aspect-ratio: auto;
  background-image: none;
  max-width: none;
  min-height: 0;
  padding: 0;
  text-align: left;
  width: 100%;
}

.development-process-section__inner::before {
  content: none;
  display: none;
}

.development-process-section__steps {
  display: grid;
  gap: 16px;
  grid-template-columns: minmax(0, 1fr);
}

.development-process-section__step {
  background: #fff;
  border: 1px solid rgba(42, 77, 251, 0.08);
  border-radius: 22px;
  box-shadow: 0 18px 40px rgba(36, 36, 84, 0.06);
  box-sizing: border-box;
  margin-top: 0;
  max-width: none;
  min-width: 0;
  padding: 24px;
  text-align: left;
  width: 100%;
}

.development-process-section__step-top {
  align-items: center;
  display: flex;
  justify-content: space-between;
  margin-bottom: 16px;
  width: 100%;
}

.development-process-section__step-icon {
  align-items: center;
  background: #eef1ff;
  border-radius: 16px;
  display: inline-flex;
  flex-shrink: 0;
  height: 56px;
  justify-content: center;
  width: 56px;
}

.development-process-section__step-icon img {
  height: 28px;
  object-fit: contain;
  width: 28px;
}

.development-process-section__step-number {
  background: linear-gradient(180deg, #2f69fb 12%, #c56bff 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  flex-shrink: 0;
  font-size: 28px;
  font-weight: 800;
  letter-spacing: -0.04em;
  line-height: 1;
}

.development-process-section__step-title {
  color: #171717;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.35;
  margin: 0 0 8px;
}

.development-process-section__step-text {
  color: #4d4d4d;
  font-size: 14px;
  line-height: 1.5;
  margin: 0;
}

@media (max-width: 639px) {
  .development-process-section {
    padding: 40px 0;
  }

  .development-process-section__header {
    margin-bottom: 24px;
  }

  .development-process-section__title {
    font-size: clamp(1.375rem, 7vw, 1.75rem);
    overflow-wrap: break-word;
  }

  .development-process-section__description {
    overflow-wrap: break-word;
  }

  .development-process-section__steps {
    gap: 14px;
  }

  .development-process-section__step {
    padding: 20px;
  }
}

@media (min-width: 640px) and (max-width: 1279px) {
  .development-process-section {
    padding: 48px 0;
  }

  .development-process-section__inner {
    aspect-ratio: auto;
    background-image: none;
    margin: 0 auto;
    max-width: none;
    min-height: 0;
    padding: 0;
    position: static;
    width: 100%;
  }

  .development-process-section__steps {
    display: grid;
    gap: 18px;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    height: auto;
    justify-content: initial;
    margin: 0;
    max-width: none;
    min-height: 0;
    width: 100%;
  }

  .development-process-section__step,
  .development-process-section__step:nth-child(odd),
  .development-process-section__step:nth-child(even) {
    align-self: stretch;
    max-width: none;
    padding: 28px 24px;
    width: 100%;
  }

  .development-process-section__step:last-child:nth-child(odd) {
    grid-column: 1 / -1;
  }

  .development-process-section__step-title {
    font-size: 17px;
    margin: 0 0 8px;
    overflow-wrap: break-word;
  }

  .development-process-section__step-text {
    font-size: 14px;
    line-height: 1.5;
    overflow-wrap: break-word;
  }
}

@media (min-width: 1024px) {
  .service-banner-logos {
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 20px;
  }

  .service-banner-logo {
    min-height: 130px;
    padding: 24px 16px;
  }

  .service-banner-logo__img {
    max-width: 110px;
    max-height: 64px;
  }
}

@media (max-width: 767px) {
  .web-services__grid--cols-2 {
    grid-template-columns: 1fr;
  }

  .web-service-card__icon-img {
    margin-inline: auto;
  }
}

@media (prefers-reduced-motion: reduce) {
  .why-choose-item,
  .why-choose-item__toggle::before,
  .why-choose-item__toggle::after,
  .why-choose-item__panel {
    transition: none;
  }

  .service-banner-logo::before {
    animation: none;
  }

  .service-banner-logo:hover {
    transform: none;
  }

  .service-banner__orbit {
    animation: none;
  }
}

@media (min-width: 1280px) {
  .development-process-section {
    padding: 120px 0 80px;
  }

  .development-process-section__header {
    margin-bottom: 8px;
  }

  .development-process-section__inner {
    background-image: url("/images/development-vector.png");
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
    min-height: 620px;
    padding: 32px 0 56px;
    text-align: center;
  }

  .development-process-section__inner::before {
    content: none;
    display: none;
  }

  .development-process-section__steps {
    display: grid;
    gap: 0 10px;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    align-items: start;
  }

  .development-process-section__step,
  .development-process-section__step:nth-child(odd),
  .development-process-section__step:nth-child(even) {
    align-self: auto;
    background: none;
    border: 0;
    border-radius: 0;
    box-shadow: none;
    grid-column: auto;
    max-width: none;
    padding: 0 12px;
    width: auto;
  }

  .development-process-section__step-top {
    display: none;
  }

  .development-process-section__step:nth-child(odd) {
    margin-top: 340px;
  }

  .development-process-section__step:nth-child(even) {
    margin-top: 0;
    padding-bottom: 24px;
  }

  .development-process-section__step:last-child:nth-child(odd) {
    grid-column: auto;
  }

  .development-process-section__step-title {
    font-size: 16px;
    margin: 0 0 8px;
  }

  .development-process-section__step-text {
    color: rgba(17, 17, 17, 1);
    line-height: 1.45;
  }
}

@media (max-width: 1280px) {
  .service-body--webdev {
    background-image: none;
    background-color: #efeef1;
    min-height: 0;
    padding-block: 48px;
  }
}

@media (max-width: 900px) {
  .collab-section__inner {
    flex-direction: column;
    text-align: center;
  }

  .collab-section__content {
    flex-basis: auto;
    max-width: none;
    width: 100%;
  }

  .collab-section__media {
    width: 100%;
  }

  .collab-section__image {
    margin-inline: auto;
    margin-top: 20px;
    max-width: min(100%, 360px);
  }
}

@media (min-width: 640px) and (max-width: 1023px) {
  .service-banner-logos {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
  }

  .service-banner-logo {
    min-height: 110px;
    padding: 20px 16px;
  }

  .service-banner-logo__img {
    max-width: 100px;
    max-height: 58px;
  }
}

@keyframes service-banner-orbit {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

@keyframes serviceBannerLogoGradient {
  0% { background-position: 0% 50%; }
  100% { background-position: 400% 50%; }
}
</style>

<?php
require __DIR__ . '/../layout/end.php';

