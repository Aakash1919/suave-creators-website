<?php
/**
 * About-page style technologies & partnerships marquee.
 *
 * Optional vars:
 * - $techMarqueeSectionClass
 * - $techStack (falls back to data/tech-stack.php)
 * - $h (htmlspecialchars helper)
 */

if (!isset($h) || !is_callable($h)) {
  $h = static function ($v): string {
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
  };
}

$techMarqueeSectionClass = $techMarqueeSectionClass ?? 'full-bleed full-bleed--edge bg-[white] pt-6 pb-10 lg:pt-10 lg:pb-14';

if (!isset($techStack) || !is_array($techStack)) {
  $techStack = require __DIR__ . '/../data/tech-stack.php';
}
?>
<section class="<?= $h($techMarqueeSectionClass) ?>" aria-label="Technologies and partnerships">
  <div class="section-inner text-center">
    <p
      class="offerings-eyebrow mb-8 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
      Technologies &amp; Partnerships
    </p>
  </div>
  <div class="about-tech-marquee overflow-hidden">
    <div class="about-tech-marquee__track">
      <?php for ($g = 0; $g < 2; $g++): ?>
        <div class="about-tech-marquee__group" <?= $g === 1 ? ' aria-hidden="true"' : '' ?>>
          <?php foreach ($techStack as $tech): ?>
            <article class="about-tech-card">
              <img src="<?= $h($tech[1]) ?>" alt="<?= $g === 0 ? $h($tech[0]) : '' ?>" width="48" height="48"
                class="about-tech-card__icon" loading="lazy">
              <span class="about-tech-card__label"><?= $h($tech[0]) ?></span>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>
