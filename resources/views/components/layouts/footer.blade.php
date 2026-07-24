@props([
    'ctaText' => "Got a project? Let's talk",
    'logo' => '/images/gradient-logo.svg',
    'phone' => '+91 97369 00142',
    'phoneHref' => 'tel:+919736900142',
    'email' => 'Info@suavecreators.com',
    'address' => '30 N Gould St, STE R Sheridan, WY 82801, USA',
    'year' => null,
    'columns' => null,
    'socialLinks' => null,
])

@php
    $year ??= date('Y');
    $columns ??= [
        'Services' => [
            ['href' => '/service/web-development-services', 'label' => 'Web Development'],
            ['href' => '/service/custom-crm-development', 'label' => 'CRM Development'],
            ['href' => '/service/enterprise-software-solutions', 'label' => 'Enterprise Software'],
            ['href' => '/service/e-commerce-development', 'label' => 'E-commerce Software'],
        ],
        'Industry' => [
            ['href' => '/industries/healthcare', 'label' => 'Healthcare'],
            ['href' => '/industries/it-software-solutions-for-startups', 'label' => 'IT Solutions'],
            ['href' => '/industries/finance-banking-software-development', 'label' => 'Banking'],
            ['href' => '/industries/retail-ecommerce-solutions', 'label' => 'E-commerce'],
            ['href' => '/industries/logistics-supply-chain-apps', 'label' => 'Logistics'],
            ['href' => '/industries/education-elearning-platforms', 'label' => 'Education'],
        ],
        'Product' => [
            ['href' => '/product', 'label' => 'HR Module'],
            ['href' => '/product', 'label' => 'Attendance & Holiday'],
            ['href' => '/product', 'label' => 'Messenger & AI Chat'],
            ['href' => '/product', 'label' => 'Daily Work Record'],
            ['href' => '/product', 'label' => 'Comments'],
            ['href' => '/product', 'label' => 'Attachment & Documents'],
        ],
        'Site Links' => [
            ['href' => '/', 'label' => 'Home'],
            ['href' => '/about-us', 'label' => 'About Us'],
            ['href' => '/services', 'label' => 'Services'],
            ['href' => '/product', 'label' => 'Product'],
            ['href' => '/blogs', 'label' => 'Blog'],
            ['href' => '/contact-us', 'label' => 'Contact Us'],
        ],
    ];
    $socialLinks ??= [
        ['href' => 'https://www.facebook.com/share/1Zt4fotyAa/', 'label' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f'],
        ['href' => 'https://www.linkedin.com/company/suave-creators/', 'label' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in'],
        ['href' => 'https://www.instagram.com/suavecreators/?igsh=MWRscWJoZXJrNG10cw%3D%3D#', 'label' => 'Instagram', 'icon' => 'fa-brands fa-instagram'],
    ];
@endphp

<footer {{ $attributes->merge(['class' => "site-footer overflow-x-clip text-white bg-[url('/images/footer-bg.png')] bg-cover bg-top bg-no-repeat"]) }}>
  <div class="site-container !px-5 sm:!px-6 lg:!px-8">
    <div class="site-footer__cta flex flex-col items-start gap-3 pb-5 pt-5 sm:flex-row sm:items-center sm:justify-between sm:gap-5 sm:pb-8 sm:pt-8">
      <p class="text-[15px] font-semibold leading-snug sm:text-lg">{{ $ctaText }}</p>
      <div class="site-footer__social flex flex-wrap items-center gap-3 text-base text-white sm:gap-8 sm:text-lg lg:gap-14">
        @foreach ($socialLinks as $social)
          <a href="{{ $social['href'] }}" target="_blank" rel="noopener noreferrer" class="site-footer__social-link !min-h-9 !min-w-9 transition hover:opacity-80 sm:!min-h-11 sm:!min-w-11" aria-label="{{ $social['label'] }}"><i class="{{ $social['icon'] }}"></i></a>
        @endforeach
      </div>
    </div>
  </div>

  <div class="h-px bg-white/10"></div>

  <div class="site-container relative z-10 !px-5 sm:!px-6 lg:!px-8">
    <div class="site-footer__main grid grid-cols-1 gap-7 py-7 sm:gap-10 sm:py-10 lg:grid-cols-12 lg:gap-12">
      <div class="site-footer__brand min-w-0 lg:col-span-3">
        <a href="{{ url('/') }}" class="inline-flex max-w-full" aria-label="Suave Creators home">
          <img src="{{ $logo }}" alt="Suave Creators" class="h-9 w-auto max-w-full object-contain sm:h-12">
        </a>
        <p class="mt-3 text-[13px] font-medium leading-5 text-[#B1B9DF] sm:mt-5 sm:text-base">
          Web &amp; Software Development<br>
          <span class="mt-1 inline-block bg-gradient-to-b from-[#2F69FB] to-[#D078FE] bg-clip-text font-extrabold text-transparent">Solutions</span>
        </p>
        <ul class="site-footer__contact mt-4 space-y-1.5 text-[12px] font-medium text-[#B1B9DF] sm:mt-6 sm:space-y-3 sm:text-[13px]">
          <li>
            <a href="{{ $phoneHref }}" class="inline-flex !min-h-0 items-center py-1 hover:text-white sm:py-0">{{ $phone }}</a>
          </li>
          <li>
            <a href="mailto:{{ strtolower($email) }}" class="inline-flex !min-h-0 max-w-full items-center break-all py-1 hover:text-white sm:py-0">{{ $email }}</a>
          </li>
          <li class="leading-5">
            <span class="inline-block max-w-[280px] sm:max-w-none">{{ $address }}</span>
          </li>
        </ul>
      </div>

      <div class="min-w-0 lg:col-span-9">
        <div class="site-footer__columns !grid !grid-cols-2 !gap-x-4 !gap-y-7 min-[480px]:!grid-cols-3 sm:!grid-cols-3 sm:!gap-x-6 sm:!gap-y-10 lg:!grid-cols-4">
          @foreach ($columns as $title => $links)
            <div class="site-footer__column min-w-0">
              <h2 class="text-[11px] font-bold uppercase tracking-wide text-white sm:text-xs">
                {{ $title }}
              </h2>

              <ul class="mt-3 space-y-1.5 sm:mt-5 sm:space-y-3">
                @foreach ($links as $link)
                  <li>
                    <a href="{{ $link['href'] }}"
                      class="group flex !min-h-0 items-start gap-1.5 py-0.5 text-[11px] leading-4 text-[#B1B9DF] transition hover:text-white sm:gap-2 sm:py-0 sm:text-[13px]">
                      <i class="fa-solid fa-chevron-right mt-0.5 shrink-0 text-[8px] text-[#B1B9DF] transition-transform group-hover:translate-x-0.5 sm:text-[9px]"
                        aria-hidden="true"></i>
                      <span class="min-w-0 break-words">{{ $link['label'] }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>

              @if ($title === 'Product')
                <a href="{{ url('/product') }}"
                  class="mt-2 inline-flex !min-h-0 items-center text-[12px] font-semibold text-white underline underline-offset-4 sm:mt-4 sm:text-[13px]">
                  More
                </a>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="footer-moving-line h-px"></div>
  <div class="site-footer__legal site-container relative z-10 flex !px-5 flex-col gap-2 py-4 text-[11px] font-medium text-[#B1B9DF] sm:!px-6 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:py-5 sm:text-[13px] lg:!px-8">
    <p class="leading-5">&copy; {{ $year }} Suave Creators. All Rights Reserved.</p>
    <p class="flex flex-wrap items-center gap-x-2 gap-y-1">
      <a href="{{ url('/privacy-policy') }}" class="inline-flex !min-h-0 items-center py-1 hover:text-white sm:py-0">Privacy Policy</a>
      <span class="text-white/30" aria-hidden="true">|</span>
      <a href="{{ url('/terms-and-conditions') }}" class="inline-flex !min-h-0 items-center py-1 hover:text-white sm:py-0">Terms &amp; Conditions</a>
    </p>
  </div>
  <a href="{{ url('/contact-us') }}" class="floating-chat" aria-label="Chat with us">
    <img src="/images/chat.svg" alt="">
  </a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@vite(['resources/js/app.js'])
@stack('scripts')
