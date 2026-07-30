<?php
$pageTitle = 'Blogs & Insights | Suave Creators';
$pageDescription = 'Explore practical insights on digital strategy, product growth, AI, startups, and design from the Suave Creators team.';
$useHeroBackground = true;
require __DIR__ . '/layout/start.php';

$h = static function ($v): string {
  return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};

$posts = require __DIR__ . '/data/blogs/posts.php';

$heroImages = [
  ['src' => '/images/blogs-hero/01-team.jpg', 'alt' => 'Team collaborating on laptops in a modern office', 'size' => 'sm'],
  ['src' => '/images/blogs-hero/02-laptop.jpg', 'alt' => 'Designer sketching wireframes on a desk', 'size' => 'md'],
  ['src' => '/images/blogs-hero/03-creative.jpg', 'alt' => 'Colleagues collaborating at a creative studio workspace', 'size' => 'lg'],
  ['src' => '/images/blogs-hero/04-desk.jpg', 'alt' => 'Hands typing on a laptop at a wooden desk', 'size' => 'md'],
  ['src' => '/images/blogs-hero/05-notebook.jpg', 'alt' => 'Notebook and fountain pen on a wooden surface', 'size' => 'sm'],
];
?>

<!-- Blogs Hero Section Start -->
<section class="blogs-hero relative z-10 w-full pb-8 pt-6 md:pb-10 md:pt-8 lg:pb-12 lg:pt-10 site-container">
  <div class="mx-auto max-w-[900px] text-center">
    <p class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-sm font-bold uppercase tracking-wide text-transparent pragati-narrow-regular">Blogs &amp; Insights</p>
    <h1 class="mt-2 text-[34px] font-semibold leading-[1.15] text-white min-[375px]:text-[40px] sm:text-5xl lg:text-[52px]">
      Ideas, Strategy &amp; <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text pb-1 font-extrabold text-transparent">Engineering Insights</span>
    </h1>
    <p class="mt-4 text-sm leading-6 text-[#B1B9DF]">Practical articles from our team on digital strategy, product growth, AI, startups, and design — written to help you build better software.</p>
  </div>

  <div class="blogs-hero__gallery" aria-label="Featured workspace imagery">
    <?php foreach ($heroImages as $image): ?>
      <figure class="blogs-hero__frame blogs-hero__frame--<?= $h($image['size']) ?>">
        <img src="<?= $h($image['src']) ?>" alt="<?= $h($image['alt']) ?>" width="440" height="560" loading="eager" decoding="async">
      </figure>
    <?php endforeach; ?>
  </div>
</section>
<!-- Blogs Hero Section End -->

<!-- Blogs Grid Section Start -->
<section class="full-bleed bg-white py-16 lg:py-20" aria-label="All blog posts">
  <div class="section-inner">
    <div class="blog-grid">
      <?php foreach ($posts as $post): ?>
        <article class="articles-card">
          <figure class="articles-card__image">
            <img src="<?= $h($post['image']) ?>" alt="<?= $h($post['title']) ?>" width="1024" height="683" loading="lazy">
          </figure>
          <div class="articles-card__body">
            <div class="articles-card__meta">
              <span class="articles-card__byline">
                <svg xmlns="https://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 24 24" fill="none"
                  stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  aria-hidden="true">
                  <circle cx="12" cy="8" r="5" />
                  <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
                <?= $h($post['author_name']) ?>
              </span>
              <time datetime="<?= $h($post['published_date']) ?>">
                <svg xmlns="https://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none"
                  stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  aria-hidden="true">
                  <path d="M8 2v4" />
                  <path d="M16 2v4" />
                  <rect width="18" height="18" x="3" y="4" rx="2" />
                  <path d="M3 10h18" />
                </svg>
                <?= $h($post['published_label']) ?>
              </time>
            </div>
            <h3><?= $h($post['title']) ?></h3>
            <p><?= $h($post['short_description']) ?></p>
            <a class="articles-card__link underline mt-2 text-sm font-semibold text-[#2A4DFB]"
              href="/blog/<?= $h($post['slug']) ?>">Read More</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- Blogs Grid Section End -->

<!-- Consultation CTA Section Start -->
<section id="consultation" class="full-bleed consultation-section">
  <div class="section-inner">
    <div class="consultation-card bg-[url('/images/consultation-bg.png')] bg-cover bg-top bg-no-repeat">
      <div class="consultation-copy">
        <h2>Have an Idea? Let's Turn It<br class="hidden sm:block"> Into a Digital Product</h2>
        <p>Whatever stage your business is at, our team is ready to help you plan, design, and build the right solution.</p>
        <div class="flex flex-wrap gap-4">
          <a href="/contact-us/#contact-id" class="consultation-cta">Get a Free Quote <svg xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></a>
        </div>
      </div>
      <div class="consultation-people">
        <div class="consultation-people__column consultation-people__column--left">
          <figure class="consultation-person consultation-person--pink"><img src="/images/consult-1.png" alt="" width="640" height="960" loading="lazy"></figure>
          <figure class="consultation-person consultation-person--orange"><img src="/images/consult-2.png" alt="" width="640" height="960" loading="lazy"></figure>
        </div>
        <div class="consultation-people__column consultation-people__column--center">
          <figure class="consultation-person consultation-person--yellow"><img src="/images/consult-3.png" alt="" width="640" height="960" loading="lazy"></figure>
          <figure class="consultation-person consultation-person--blue"><img src="/images/consult-5.png" alt="" width="640" height="959" loading="lazy"></figure>
        </div>
        <div class="consultation-people__column consultation-people__column--right">
          <figure class="consultation-person consultation-person--coral"><img src="/images/consult-4.png" alt="" width="640" height="960" loading="lazy"></figure>
          <figure class="consultation-person consultation-person--cyan"><img src="/images/consult-6.png" alt="" width="640" height="960" loading="lazy"></figure>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Consultation CTA Section End -->

<style>
.blogs-hero__gallery {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: clamp(0.5rem, 1.6vw, 1.125rem);
  margin-top: clamp(1.25rem, 3.5vw, 2.25rem);
  width: 100%;
}

.blogs-hero__frame {
  flex: 1 1 0;
  min-width: 0;
  overflow: hidden;
  border-radius: clamp(12px, 2vw, 20px);
  box-shadow: 0 14px 36px rgba(5, 10, 36, 0.28);
}

.blogs-hero__frame img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.blogs-hero__frame--sm {
  height: clamp(6.5rem, 22vw, 16rem);
}

.blogs-hero__frame--md {
  height: clamp(9rem, 30vw, 22rem);
}

.blogs-hero__frame--lg {
  height: clamp(11.5rem, 38vw, 28rem);
}

.blog-grid {
  display: grid;
  gap: 26px;
  grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 1024px) {
  .blog-grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 26px;
  }
}

@media (min-width: 640px) and (max-width: 1023px) {
  .blog-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}
</style>

<?php require __DIR__ . '/layout/end.php'; ?>
