<?php
$pageTitle = "Contact Suave Creators | Have a Project in Mind? Let's Discuss";
$pageDescription = 'Tell Suave Creators about your website, app, or custom software project. Our team usually responds within 12 business hours.';
$useHeroBackground = true;
$heroBackgroundImage = '/images/cover_banner.png';
require __DIR__ . '/layout/start.php';

$contactCards = [
  [
    'icon' => 'fa-solid fa-location-dot',
    'label' => 'Visit our office',
    'title' => 'Address',
    'offices' => [
      [
        'flag' => 'us',
        'display' => '30 N Gould St, STE R, Sheridan, WY 82801, USA',
        'lines' => ['30 N Gould St, STE R,', 'Sheridan, WY 82801, USA'],
        'map_embed' => 'https://maps.google.com/maps?q=' . rawurlencode('30 N Gould St, STE R, Sheridan, WY 82801, USA') . '&z=16&output=embed',
      ],
      [
        'flag' => 'in',
        'display' => '3M Plaza, Second Floor, Maranda, Kasoti, Palampur, Himachal Pradesh 176102',
        'lines' => ['3M Plaza, Second Floor,', 'Maranda, Kasoti, Palampur,', 'Himachal Pradesh 176102'],
        'map_embed' => 'https://maps.google.com/maps?q=' . rawurlencode('3M Plaza, Maranda, Kasoti, Palampur, Himachal Pradesh 176102') . '&z=16&output=embed',
      ],
    ],
    'lines' => [],
    'links' => [],
  ],
  [
    'icon' => 'fa-regular fa-envelope',
    'label' => 'Write to our team',
    'title' => 'Mail Support',
    'offices' => [],
    'lines' => [],
    'links' => [
      ['href' => 'mailto:info@suavecreators.com', 'text' => 'info@suavecreators.com'],
    ],
  ],
  [
    'icon' => 'fa-solid fa-phone',
    'label' => 'Speak with an expert',
    'title' => 'Phone',
    'offices' => [],
    'lines' => [],
    'links' => [
      ['href' => 'tel:+918894900142', 'text' => '+91 88949 00142'],
      ['href' => 'tel:+911894455019', 'text' => '+91 18944 55019'],
    ],
  ],
];

$offices = $contactCards[0]['offices'];

$faqs = [
  [
    'How soon will I get a response after contacting your team?',
    'Usually, we respond within 12 hours on business days. If you have shared project details, our team will review them and get back to you with the next steps or a discovery call invite.',
  ],
  [
    'Do you work with clients outside of India?',
    'Yes! We work with clients globally. Our expert team is experienced in managing remote projects and communicating effectively across different time zones.',
  ],
  [
    'What information should I include when contacting you about a project?',
    'You can include your project requirements, budget range, and deadline expectations, if available. This helps us understand your vision and provide a more accurate proposal or consultation.',
  ],
];
?>

<!-- Contact Hero Start -->
<section
  class="full-bleed relative z-10 overflow-hidden bg-[#00003f] bg-[url('/images/cover_banner.png')] bg-cover bg-top bg-no-repeat pb-12 pt-8 sm:pb-16 sm:pt-10 lg:min-h-[580px] lg:pb-20 lg:pt-[52px]">
  <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="/images/hero_Pattern(left).svg" alt=""
      class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-soft-light">
  </div>
  <div class="pointer-events-none absolute -right-24 top-10 h-72 w-72 rounded-full bg-[#7A5FF8]/20 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -bottom-32 left-1/3 h-72 w-72 rounded-full bg-[#2A4DFB]/20 blur-3xl" aria-hidden="true"></div>

  <div class="section-inner relative grid items-center gap-12 lg:grid-cols-[1.08fr_0.92fr] lg:gap-16">
    <div class="max-w-[670px]">
      <p
        class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-sm font-bold uppercase tracking-wide text-transparent pragati-narrow-regular">
        Let’s create something remarkable
      </p>

      <h1
        class="mb-2 mt-2 text-[36px] font-semibold leading-[100%] text-white min-[375px]:text-[42px] sm:text-5xl lg:text-[60px]">
        Have a project<br>
        in mind?
        <span
          class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text font-extrabold text-transparent">
          Let’s discuss.
        </span>
      </h1>

      <p class="mb-2 mt-2 max-w-[610px] text-[12px] leading-5 text-[#B1B9DF] md:text-sm md:leading-6">
        We always love to hear from you! Whether you’re looking to develop a business website, app, or custom digital
        solution, our professional team is here to help you turn your ideas into reality.
      </p>

      <div class="mt-8 flex flex-wrap items-center gap-4 sm:gap-7">
        <a href="#contact-id"
          class="group inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:text-sm">
          Send a Message
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
            <path d="M18 8L22 12L18 16"></path>
            <path d="M2 12H22"></path>
          </svg>
        </a>
        <a href="tel:+918894900142"
          class="inline-flex items-center gap-2 whitespace-nowrap border-b border-white/70 text-[13px] font-semibold text-white sm:text-sm">
          <i class="fa-solid fa-phone text-xs" aria-hidden="true"></i>
          +91 88949 00142
        </a>
      </div>
    </div>

    <div class="relative mx-auto w-full max-w-[510px]" aria-label="How our consultation works">
      <div class="absolute -inset-5 rounded-[40px] border border-white/[0.06]"></div>
      <div class="relative overflow-hidden rounded-[30px] border border-white/10 bg-white/[0.07] p-6 shadow-[0_30px_80px_rgba(0,0,0,0.3)] backdrop-blur-xl sm:p-8">
        <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-6">
          <div>
            <p class="text-sm font-bold uppercase tracking-wide text-[#8598F8] pragati-narrow-regular">What happens next</p>
            <h2 class="mt-2 text-xl font-semibold text-white sm:text-2xl">A clear path from idea to plan</h2>
          </div>
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#2A4DFB] to-[#8B5CF6] text-white shadow-lg">
            <i class="fa-regular fa-message" aria-hidden="true"></i>
          </span>
        </div>

        <ol class="mt-2">
          <li class="group flex gap-4 border-b border-white/10 py-5">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white">01</span>
            <div>
              <h3 class="text-sm font-semibold text-white">Share your project</h3>
              <p class="mt-1 text-[13px] leading-5 text-[#B1B9DF]">Tell us your goals, timeline, and current challenges.</p>
            </div>
          </li>
          <li class="group flex gap-4 border-b border-white/10 py-5">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white">02</span>
            <div>
              <h3 class="text-sm font-semibold text-white">Hear from an expert</h3>
              <p class="mt-1 text-[13px] leading-5 text-[#B1B9DF]">We usually respond within 12 hours on business days.</p>
            </div>
          </li>
          <li class="group flex gap-4 pt-5">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white">03</span>
            <div>
              <h3 class="text-sm font-semibold text-white">Get your next steps</h3>
              <p class="mt-1 text-[13px] leading-5 text-[#B1B9DF]">We’ll suggest a discovery call and a practical way forward.</p>
            </div>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Contact Hero End -->

<!-- Contact Form Start -->
<section id="contact-id"
  class="full-bleed scroll-mt-6 overflow-hidden bg-[url('/images/web-bg.png')] bg-cover bg-center py-12 sm:py-16 lg:py-20"
  aria-labelledby="contact-form-heading">
  <div class="section-inner contact-form-section-inner">
    <div class="contact-form-panel">
      <aside class="contact-form-panel__info" aria-labelledby="contact-form-heading">
        <p class="contact-form-panel__eyebrow">
          <span class="contact-form-panel__eyebrow-bar" aria-hidden="true"></span>
          Contact · 1-day reply
        </p>
        <h2 id="contact-form-heading" class="contact-form-panel__title">
          Tell us what you&rsquo;re<br>
          <span>trying to fix.</span>
        </h2>
        <p class="contact-form-panel__lead">
          Prefer a call or email? We read every note ourselves and reply within one business day.
        </p>

        <div class="contact-form-panel__meta">
          <a class="contact-form-panel__meta-card" href="tel:+918894900142">
            <span class="contact-form-panel__meta-label">Phone</span>
            <span class="contact-form-panel__meta-value">+91 88949 00142</span>
            <span class="contact-form-panel__meta-note">Mon–Fri · 1:30PM–9:30PM</span>
          </a>
          <a class="contact-form-panel__meta-card" href="mailto:info@suavecreators.com">
            <span class="contact-form-panel__meta-label">Email</span>
            <span class="contact-form-panel__meta-value">info@suavecreators.com</span>
            <span class="contact-form-panel__meta-note">Real person, not a queue</span>
          </a>
        </div>
      </aside>

      <div class="contact-form-panel__form-wrap">
        <div class="contact-form-panel__form">
          <header class="contact-form-panel__form-intro">
            <p class="contact-form-panel__form-status">
              <span aria-hidden="true"></span>
              Live intake
            </p>
            <h3 class="contact-form-panel__form-title">Start the conversation</h3>
          </header>

          <form action="/contact/submit" method="post" class="contact-form-panel__fields" data-contact-form>
            <div class="contact-form-panel__row">
              <label for="contact-name">
                <span class="contact-form-panel__label-text">Full name</span>
                <input id="contact-name" name="name" type="text" autocomplete="name" required placeholder="Jane Cooper">
              </label>
              <label for="contact-email">
                <span class="contact-form-panel__label-text">Email</span>
                <input id="contact-email" name="email" type="email" autocomplete="email" required placeholder="you@company.com">
              </label>
            </div>

            <div class="contact-form-panel__row">
              <label for="contact-phone">
                <span class="contact-form-panel__label-text">Phone</span>
                <input id="contact-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required placeholder="+91 90000 00000">
              </label>
              <label for="contact-service">
                <span class="contact-form-panel__label-text">Service</span>
                <select id="contact-service" name="service" required>
                  <option value="" disabled selected>Select a service</option>
                  <option value="web-development">Web Development</option>
                  <option value="ai-solutions">AI Solutions</option>
                  <option value="ui-ux-design">UI/UX Design</option>
                  <option value="ecommerce">E-commerce Development</option>
                  <option value="custom-crm">Custom CRM Development</option>
                  <option value="enterprise-software">Enterprise Software</option>
                  <option value="other">Other</option>
                </select>
              </label>
            </div>

            <label for="contact-message" class="contact-form-panel__message">
              <span class="contact-form-panel__label-text">What are you trying to fix?</span>
              <textarea id="contact-message" name="message" rows="3" minlength="10" required
                placeholder="A sentence or two about the problem is enough."></textarea>
            </label>

            <div class="contact-form-panel__actions">
              <button type="submit" class="u-btn-cta contact-form-panel__submit">
                Send inquiry
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  aria-hidden="true">
                  <path d="M18 8L22 12L18 16"></path>
                  <path d="M2 12H22"></path>
                </svg>
              </button>
              <a href="tel:+918894900142">or call +91 88949 00142</a>
            </div>

            <p class="contact-form-panel__disclaimer">
              Reply within 1 business day.
              <a href="/privacy-policy">Privacy policy</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Contact Form End -->


<!-- Technologies & Partnerships Marquee Start -->
<?php
$techMarqueeSectionClass = 'full-bleed full-bleed--edge bg-white py-10 lg:py-14 bg-[url("/images/web-bg.png")] bg-cover bg-center';
require __DIR__ . '/partials/tech-partnerships-marquee.php';
?>
<!-- Technologies & Partnerships Marquee End -->

<!-- Contact Information Start -->
<?php
  $mapOffices = $offices ?? [];
  $activeOffice = $mapOffices[0] ?? null;
?>
<section class="full-bleed contact-reach-section py-16 sm:py-20 lg:py-24"
  style="background-image: url('/images/about-section-bg.png');"
  aria-labelledby="contact-details-heading"
  data-contact-reach>
  <div class="section-inner">
    <header class="contact-reach__header">
      <p class="contact-reach__eyebrow">
        <span class="contact-reach__eyebrow-bar" aria-hidden="true"></span>
        Prefer another way to reach us?
      </p>
      <h2 id="contact-details-heading" class="contact-reach__title">
        We’re always within reach
      </h2>
      <p class="contact-reach__lead">
        Visit, email, or call us. Choose whichever way works best for you.
      </p>
    </header>

    <div class="contact-reach">
      <div class="contact-reach__map">
        <iframe
          data-contact-map
          title="<?= htmlspecialchars(($activeOffice['display'] ?? 'Office location') . ' map') ?>"
          src="<?= htmlspecialchars($activeOffice['map_embed'] ?? '') ?>"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          allowfullscreen></iframe>
      </div>

      <div class="contact-reach__details" role="list">
        <div class="contact-reach__panel-head">
          <h3 class="contact-reach__panel-title">Contact</h3>
        </div>

        <?php foreach ($contactCards as $card): ?>
          <div class="contact-reach__item" role="listitem">
            <span class="contact-reach__item-icon" aria-hidden="true">
              <i class="<?= htmlspecialchars($card['icon']) ?>"></i>
            </span>

            <div class="contact-reach__item-content">
              <p class="contact-reach__item-label"><?= htmlspecialchars($card['label']) ?></p>
              <h3 class="contact-reach__item-title"><?= htmlspecialchars($card['title']) ?></h3>

              <div class="contact-reach__item-body">
                <?php if (! empty($card['offices'])): ?>
                  <?php foreach ($card['offices'] as $officeIndex => $office): ?>
                    <button
                      type="button"
                      class="contact-reach__office<?= $officeIndex === 0 ? ' is-active' : '' ?>"
                      data-contact-office
                      data-map-src="<?= htmlspecialchars($office['map_embed']) ?>"
                      data-map-title="<?= htmlspecialchars(($office['display'] ?? 'Office location') . ' map') ?>"
                      aria-pressed="<?= $officeIndex === 0 ? 'true' : 'false' ?>">
                      <span class="contact-reach__flag" aria-hidden="true">
                        <?php if (($office['flag'] ?? 'us') === 'in'): ?>
                          <svg viewBox="0 0 24 16" width="24" height="16" focusable="false">
                            <rect width="24" height="5.33" y="0" fill="#FF9933"/>
                            <rect width="24" height="5.34" y="5.33" fill="#FFFFFF"/>
                            <rect width="24" height="5.33" y="10.67" fill="#138808"/>
                            <circle cx="12" cy="8" r="2.1" fill="none" stroke="#000080" stroke-width="0.7"/>
                            <circle cx="12" cy="8" r="0.45" fill="#000080"/>
                          </svg>
                        <?php else: ?>
                          <svg viewBox="0 0 24 16" width="24" height="16" focusable="false">
                            <rect width="24" height="16" fill="#B22234"/>
                            <rect y="1.23" width="24" height="1.23" fill="#FFFFFF"/>
                            <rect y="3.69" width="24" height="1.23" fill="#FFFFFF"/>
                            <rect y="6.15" width="24" height="1.23" fill="#FFFFFF"/>
                            <rect y="8.62" width="24" height="1.23" fill="#FFFFFF"/>
                            <rect y="11.08" width="24" height="1.23" fill="#FFFFFF"/>
                            <rect y="13.54" width="24" height="1.23" fill="#FFFFFF"/>
                            <rect width="9.6" height="8.62" fill="#3C3B6E"/>
                          </svg>
                        <?php endif; ?>
                      </span>
                      <span class="contact-reach__office-lines">
                        <?php foreach ($office['lines'] as $line): ?>
                          <span class="contact-reach__office-line"><?= htmlspecialchars($line) ?></span>
                        <?php endforeach; ?>
                      </span>
                    </button>
                  <?php endforeach; ?>
                <?php endif; ?>

                <?php if (! empty($card['links'])): ?>
                  <div class="contact-reach__links">
                    <?php foreach ($card['links'] as $link): ?>
                      <a href="<?= htmlspecialchars($link['href']) ?>" class="contact-reach__link">
                        <?= htmlspecialchars($link['text']) ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<!-- Contact Information End -->

<!-- FAQ Section Start -->
<section class="full-bleed faq-section faq-section--align faq-section--contact bg-[url('/images/web-bg.png')] bg-cover bg-center" aria-labelledby="contact-faq-heading">
  <div class="faq-section__inner section-inner">
    <div class="faq-section__intro">
      <p class="faq-section__eyebrow flex items-center gap-2">
        <span class="inline-block h-4 w-[2px] rounded-full bg-gradient-to-b from-[#2A4DFB] to-[#7A5FF8]"></span>
        <span class="bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold text-transparent">
          Questions before you get started?
        </span>
      </p>
      <h2 id="contact-faq-heading">Frequently Ask Question</h2>
      <p class="faq-section__description">Here are the most asked questions based on feedback from our users.</p>
      <?php
        $faqCtaHref = '#contact-id';
        $faqCtaLabel = 'Send a Message';
        require __DIR__ . '/partials/faq-cta-button.php';
      ?>
      <img class="faq-section__image" src="/images/faq-gif.gif" alt="Business team collaborating around a table"
        width="640" height="960" loading="lazy">
    </div>

    <div class="faq-list">
      <?php foreach ($faqs as $index => $faq): ?>
        <?php $faqNumber = $index + 1; ?>
        <div class="faq-item<?= $index === 0 ? ' is-open' : '' ?>">
          <button type="button" class="faq-item__summary" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
            aria-controls="contact-faq-answer-<?= $faqNumber ?>" id="contact-faq-question-<?= $faqNumber ?>">
            <span><?= htmlspecialchars($faq[0]) ?></span>
            <i class="fa-solid fa-chevron-down faq-item__chevron" aria-hidden="true"></i>
          </button>
          <div class="faq-item__answer" id="contact-faq-answer-<?= $faqNumber ?>" role="region"
            aria-labelledby="contact-faq-question-<?= $faqNumber ?>"
            aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
            <div class="faq-item__answer-inner">
              <p><?= htmlspecialchars($faq[1]) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- FAQ Section End -->

<script>
document.addEventListener('DOMContentLoaded', function () {
  var root = document.querySelector('[data-contact-reach]');
  if (root) {
    var map = root.querySelector('[data-contact-map]');
    var offices = root.querySelectorAll('[data-contact-office]');
    if (map && offices.length) {
      offices.forEach(function (button) {
        button.addEventListener('click', function () {
          var src = button.getAttribute('data-map-src');
          var title = button.getAttribute('data-map-title') || 'Office location map';
          if (src && map.getAttribute('src') !== src) {
            map.setAttribute('src', src);
            map.setAttribute('title', title);
          }
          offices.forEach(function (item) {
            var active = item === button;
            item.classList.toggle('is-active', active);
            item.setAttribute('aria-pressed', active ? 'true' : 'false');
          });
        });
      });
    }
  }

  var faqItems = document.querySelectorAll('.faq-list .faq-item');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
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
      if (e.propertyName === 'height' && item.classList.contains('is-open')) {
        a.style.height = 'auto'; a.removeEventListener('transitionend', once);
      }
    });
  }
  function closeFaq(item) {
    var a = item.querySelector('.faq-item__answer');
    if (reduce.matches) {
      item.classList.remove('is-open'); setAria(item, false); a.style.height = '0px'; return;
    }
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

});
</script>


<style>
/* Page-specific styles (moved from css/style.css) */
.site-main > .full-bleed > .section-inner.contact-form-section-inner{
  grid-column: full;
  justify-self: center;
  max-width: 1380px;
  padding-inline: var(--site-gutter);
  width: 100%;
}

.contact-form-panel{
  background-color: #0b1228;
  background-image: url("/images/blur-contact.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: 100% 100%;
  border-radius: 28px;
  display: grid;
  max-width: 100%;
  overflow: hidden;
  width: 100%;
  padding: 20px;
}

.contact-form-panel__info{
  color: #ffffff;
  display: flex;
  flex-direction: column;
  gap: 0;
  padding: 32px 24px 28px;
  position: relative;
  z-index: 1;
}

.contact-form-panel__eyebrow{
  align-items: center;
  color: #9eb0ff;
  display: inline-flex;
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-size: 12px;
  font-weight: 600;
  gap: 10px;
  letter-spacing: 0.06em;
  line-height: 1;
  margin: 0;
  text-transform: uppercase;
}

.contact-form-panel__eyebrow-bar{
  background: linear-gradient(90deg, var(--cfp-blue), #6ea0ff);
  border-radius: 999px;
  display: inline-block;
  flex-shrink: 0;
  height: 2px;
  width: 28px;
}

.contact-form-panel__title{
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-size: clamp(2rem, 4.2vw, 3rem);
  font-weight: 700;
  letter-spacing: -0.03em;
  line-height: 1.1;
  margin: 18px 0 0;
  max-width: 16ch;
}

.contact-form-panel__title span{
  color: #6ea0ff;
  font-weight: 600;
}

.contact-form-panel__lead{
  color: var(--cfp-muted);
  font-size: 15px;
  line-height: 1.55;
  margin: 16px 0 0;
  max-width: 36ch;
}

.contact-form-panel__meta{
  display: grid;
  gap: 12px;
  margin-top: 28px;
}

.contact-form-panel__meta-card{
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid var(--cfp-line);
  border-radius: 16px;
  display: grid;
  gap: 4px;
  padding: 16px 18px;
  text-decoration: none;
  transition: background 0.25s ease, border-color 0.25s ease, transform 0.25s ease;
}

.contact-form-panel__meta-card:hover{
  background: rgba(42, 77, 251, 0.16);
  border-color: rgba(110, 160, 255, 0.45);
  transform: translateY(-2px);
}

.contact-form-panel__meta-label{
  color: rgba(255, 255, 255, 0.45);
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.1em;
  text-transform: uppercase;
}

.contact-form-panel__meta-value{
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  letter-spacing: -0.01em;
}

.contact-form-panel__meta-note{
  color: var(--cfp-muted);
  font-size: 13px;
  line-height: 1.4;
}

.contact-form-panel__form-wrap{
  min-width: 0;
  padding: 0 20px 28px;
  position: relative;
  z-index: 1;
}

.contact-form-panel__form{
  background: #ffffff;
  border-radius: 22px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  max-width: 100%;
  min-width: 0;
  padding: 28px 22px 24px;
  position: relative;
}

.contact-form-panel__form-intro{
  margin-bottom: 22px;
}

.contact-form-panel__form-status{
  align-items: center;
  color: #6b7280;
  display: inline-flex;
  font-size: 11px;
  font-weight: 700;
  gap: 8px;
  letter-spacing: 0.14em;
  margin: 0;
  text-transform: uppercase;
}

.contact-form-panel__form-status span{
  animation: contact-form-pulse 1.8s ease-in-out infinite;
  background: #22c55e;
  border-radius: 999px;
  box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.45);
  display: inline-block;
  flex-shrink: 0;
  height: 8px;
  width: 8px;
}

@keyframes contact-form-pulse{
  0%,
  100% {
    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.45);
  }
  50% {
    box-shadow: 0 0 0 6px rgba(34, 197, 94, 0);
  }
}

.contact-form-panel__form-title{
  color: var(--cfp-ink);
  font-family: "PP Mori", "Roboto Flex", ui-sans-serif, system-ui, sans-serif;
  font-size: clamp(1.5rem, 2.4vw, 1.85rem);
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 1.2;
  margin: 10px 0 0;
}

.contact-form-panel__fields{
  display: grid;
  gap: 16px;
}

.contact-form-panel__row{
  display: grid;
  gap: 16px;
}

.contact-form-panel__fields label{
  display: grid;
  gap: 8px;
  margin: 0;
}

.contact-form-panel__label-text{
  color: #374151;
  font-size: 13px;
  font-weight: 600;
}

.contact-form-panel__fields input,
.contact-form-panel__fields select,
.contact-form-panel__fields textarea{
  background: #f7f8fc;
  border: 1px solid transparent;
  border-radius: 12px;
  color: #171717;
  font-family: inherit;
  font-size: 13px;
  outline: none;
  transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
  width: 100%;
}

.contact-form-panel__fields input,
.contact-form-panel__fields select{
  height: 46px;
  padding: 12px 16px;
}

.contact-form-panel__fields textarea{
  line-height: 1.5;
  min-height: 96px;
  padding: 14px 16px;
  resize: vertical;
}

.contact-form-panel__fields select{
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
  background-position: right 14px center;
  background-repeat: no-repeat;
  background-size: 16px;
  color: #9ca3af;
  cursor: pointer;
  padding-right: 42px;
}

.contact-form-panel__fields select:not(:invalid){
  color: #171717;
}

.contact-form-panel__fields input::placeholder,
.contact-form-panel__fields textarea::placeholder{
  color: #9ca3af;
}

.contact-form-panel__fields input:hover,
.contact-form-panel__fields select:hover,
.contact-form-panel__fields textarea:hover{
  background: #ffffff;
  border-color: #d8dce8;
}

.contact-form-panel__fields input:focus,
.contact-form-panel__fields select:focus,
.contact-form-panel__fields textarea:focus{
  background: #ffffff;
  border-color: var(--cfp-blue);
  box-shadow: 0 0 0 4px var(--cfp-blue-soft);
}

.contact-form-panel__actions{
  align-items: stretch;
  display: flex;
  flex-direction: column;
  gap: 14px;
  margin-top: 4px;
}

.contact-form-panel__submit{
  align-items: center;
  background: linear-gradient(90deg, #2a4dfb 57.12%, #0026e3 100%);
  border-radius: 999px;
  color: #ffffff;
  display: inline-flex;
  font-size: 14px;
  font-weight: 700;
  gap: 8px;
  height: 34px;
  justify-content: center;
  min-height: 34px;
  padding: 0 20px;
  transition: filter 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
  width: 100%;
}

.contact-form-panel__submit:hover{
  box-shadow: 0 10px 28px rgba(42, 77, 251, 0.35);
  filter: brightness(1.06);
  transform: translateY(-1px);
}

.contact-form-panel__submit svg{
  transition: transform 0.3s ease;
}

.contact-form-panel__submit:hover svg{
  transform: translateX(4px);
}

.contact-form-panel__actions a{
  color: #6b7280;
  font-size: 14px;
  font-weight: 500;
  text-align: center;
  transition: color 0.2s ease;
}

.contact-form-panel__actions a:hover{
  color: var(--cfp-blue);
}

.contact-form-panel__disclaimer{
  color: #9ca3af;
  font-size: 12px;
  line-height: 1.5;
  margin: 2px 0 0;
}

.contact-form-panel__disclaimer a{
  color: inherit;
  text-decoration: underline;
  text-underline-offset: 2px;
  transition: color 0.2s ease;
}

.contact-form-panel__disclaimer a:hover{
  color: var(--cfp-blue);
}

@media (max-width: 1023px) {
.contact-form-panel{
    padding: 14px;
  }

.contact-form-panel__info{
    padding: 28px 18px 24px;
  }

.contact-form-panel__form-wrap{
    padding: 0 10px 20px;
  }

.contact-form-panel__form{
    padding: 24px 18px 20px;
  }

.contact-form-panel__submit.u-btn-cta{
    height: 34px;
    min-height: 34px;
    padding-block: 0;
  }
}

@media (min-width: 640px) {
.contact-form-panel__info{
    padding: 40px 28px 32px;
  }

.contact-form-panel__meta{
    grid-template-columns: 1fr 1fr;
  }

.contact-form-panel__form-wrap{
    padding: 0 16px 32px;
  }

.contact-form-panel__form{
    padding: 32px 28px 28px;
  }

.contact-form-panel__row{
    grid-template-columns: 1fr 1fr;
  }

.contact-form-panel__actions{
    align-items: center;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 20px;
  }

.contact-form-panel__submit{
    min-width: 180px;
    width: auto;
  }

.contact-form-panel__actions a{
    text-align: left;
  }
}

@media (min-width: 1024px) {
.contact-form-panel{
    align-items: stretch;
    grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
    min-height: 640px;
    padding: 20px;
  }

.contact-form-panel__submit{
    height: 36px;
    min-height: 36px;
  }

.contact-form-panel__info{
    justify-content: center;
    padding: 48px 40px 48px 56px;
  }

.contact-form-panel__meta{
    grid-template-columns: 1fr;
    max-width: 340px;
  }

.contact-form-panel__form-wrap{
    align-items: center;
    display: flex;
    padding: 40px 48px 40px 20px;
  }

.contact-form-panel__form{
    padding: 36px 36px 32px;
    width: 100%;
  }
}

@media (min-width: 1280px) {
.contact-form-panel{
    min-height: 680px;
  }

.contact-form-panel__info{
    padding: 56px 48px 56px 72px;
  }

.contact-form-panel__form-wrap{
    padding: 48px 64px 48px 24px;
  }

.contact-form-panel__form{
    padding: 40px 40px 36px;
  }
}

@media (prefers-reduced-motion: reduce) {
.contact-form-panel__form-status span{
    animation: none;
  }

.contact-form-panel__fields input,
.contact-form-panel__fields select,
.contact-form-panel__fields textarea,
.contact-form-panel__meta-card,
.contact-form-panel__submit,
.contact-form-panel__submit svg,
.contact-form-panel__actions a,
.contact-form-panel__disclaimer a{
    transition: none;
  }
}
</style>

<?php require __DIR__ . '/layout/end.php'; ?>
