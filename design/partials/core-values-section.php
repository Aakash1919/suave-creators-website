<?php
/** @var callable $h */
/** @var string $coreValuesEyebrow */
/** @var string $coreValuesTitle */
/** @var string $coreValuesDescription */
/** @var array<int, array{icon: string, title: string, desc: string, image: string, alt: string}> $coreValuesItems */
/** @var string|null $coreValuesTitleId */
/** @var string|null $coreValuesGridClass */

$coreValuesTitleId = $coreValuesTitleId ?? null;
$coreValuesGridClass = $coreValuesGridClass ?? '';
?>
<section class="full-bleed core-values core-values-section bg-[url('/images/background_core_values.png')] bg-cover bg-top bg-no-repeat py-16 lg:py-20"<?= $coreValuesTitleId ? ' aria-labelledby="' . $h($coreValuesTitleId) . '"' : '' ?>>
  <div class="core-values__inner section-inner">
    <?php require __DIR__ . '/core-values-symbols.php'; ?>

    <header class="core-values__header">
      <div class="flex items-start gap-2 mb-4">
        <span class="inline-block w-[2px] h-[16px] bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8] rounded-full"></span>
        <span class="text-[14px] font-bold bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-transparent inline-block">
          <?= $h($coreValuesEyebrow) ?>
        </span>
      </div>
      <div class="core-values__heading">
        <h2<?= $coreValuesTitleId ? ' id="' . $h($coreValuesTitleId) . '"' : '' ?>><?= $h($coreValuesTitle) ?></h2>
        <p><?= $h($coreValuesDescription) ?></p>
      </div>
    </header>

    <div class="core-values__slider">
      <div class="core-values__grid<?= $coreValuesGridClass !== '' ? ' ' . $h($coreValuesGridClass) : '' ?> coreValuesSwiper swiper">
        <div class="swiper-wrapper">
          <?php foreach ($coreValuesItems as $item): ?>
            <div class="swiper-slide">
              <article class="core-value-card">
                <div class="core-value-card__content">
                  <svg class="core-value-card__icon" aria-hidden="true">
                    <use href="#core-value-<?= $h($item['icon']) ?>"></use>
                  </svg>
                  <h3><?= $h($item['title']) ?></h3>
                  <p><?= $h($item['desc']) ?></p>
                </div>
                <div class="core-value-card__image">
                  <img src="<?= $h($item['image']) ?>" alt="<?= $h($item['alt']) ?>" loading="lazy">
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="core-values__controls">
        <button class="core-values-prev" type="button" aria-label="Previous process step">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
        </button>
        <div class="core-values-pagination" aria-label="Process steps pagination"></div>
        <button class="core-values-next" type="button" aria-label="Next process step">
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper === 'undefined') return;

  var el = document.querySelector('.coreValuesSwiper');
  if (!el || el.dataset.swiperBound === '1') return;
  el.dataset.swiperBound = '1';

  var mq = window.matchMedia('(min-width: 768px) and (max-width: 1023px)');
  var swiper = null;

  function syncCoreValuesSwiper() {
    if (mq.matches) {
      if (swiper) return;
      swiper = new Swiper(el, {
        slidesPerView: 2,
        spaceBetween: 24,
        speed: 500,
        watchOverflow: true,
        keyboard: { enabled: true, onlyInViewport: true },
        navigation: {
          nextEl: '.core-values-next',
          prevEl: '.core-values-prev'
        },
        pagination: {
          el: '.core-values-pagination',
          clickable: true
        },
        a11y: {
          prevSlideMessage: 'Previous process step',
          nextSlideMessage: 'Next process step'
        }
      });
      return;
    }

    if (swiper) {
      swiper.destroy(true, true);
      swiper = null;
    }
  }

  syncCoreValuesSwiper();
  if (typeof mq.addEventListener === 'function') {
    mq.addEventListener('change', syncCoreValuesSwiper);
  } else if (typeof mq.addListener === 'function') {
    mq.addListener(syncCoreValuesSwiper);
  }
});
</script>
