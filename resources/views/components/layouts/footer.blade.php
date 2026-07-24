<footer
  {{ $attributes->merge(['class' => 'site-footer overflow-x-clip text-white']) }}
  @if (filled($backgroundImage))
    style="background-image: url('{{ $backgroundImage }}'); background-position: top; background-repeat: no-repeat; background-size: cover;"
  @endif
>
  <div class="site-container !px-5 sm:!px-6 lg:!px-8">
    <div class="site-footer__cta">
      <p class="text-[15px] font-semibold leading-snug sm:text-lg">{{ $ctaText }}</p>
      <div class="site-footer__social text-base text-white sm:text-lg">
        @foreach ($socialLinks as $social)
          <a href="{{ $social['href'] }}" target="_blank" rel="noopener noreferrer" class="site-footer__social-link transition hover:opacity-80" aria-label="{{ $social['label'] }}"><i class="{{ $social['icon'] }}"></i></a>
        @endforeach
      </div>
    </div>
  </div>

  <div class="h-px bg-white/10"></div>

  <div class="site-container relative z-10 !px-5 sm:!px-6 lg:!px-8">
    <div class="site-footer__main">
      <div class="site-footer__brand">
        <a href="{{ url('/') }}" class="inline-flex max-w-full" aria-label="Suave Creators home">
          <img src="{{ $logo }}" alt="Suave Creators" class="h-9 w-auto max-w-full object-contain sm:h-12">
        </a>
        <p class="mt-3 text-[13px] font-medium leading-5 text-[#B1B9DF] sm:mt-5 sm:text-base">
          Web &amp; Software Development<br>
          <span class="site-footer__brand-accent">Solutions</span>
        </p>
        <ul class="site-footer__contact">
          <li>
            <a href="{{ $phoneHref }}">{{ $phone }}</a>
          </li>
          <li>
            <a href="mailto:{{ strtolower($email) }}">{{ $email }}</a>
          </li>
          <li class="leading-5">
            <span class="inline-block max-w-[280px] sm:max-w-none">{{ $address }}</span>
          </li>
        </ul>
      </div>

      <div class="min-w-0">
        <div class="site-footer__columns">
          @foreach ($columns as $title => $links)
            <div class="site-footer__column">
              <h2 class="text-[11px] font-bold uppercase tracking-wide text-white sm:text-xs">
                {{ $title }}
              </h2>

              <ul class="mt-3 space-y-1.5 sm:mt-5 sm:space-y-3">
                @foreach ($links as $link)
                  <li>
                    <a href="{{ $link['href'] }}" class="group flex items-start gap-1.5 py-0.5 text-[11px] leading-4 text-[#B1B9DF] transition hover:text-white sm:gap-2 sm:py-0 sm:text-[13px]">
                      <i class="fa-solid fa-chevron-right mt-0.5 shrink-0 text-[8px] text-[#B1B9DF] transition-transform group-hover:translate-x-0.5 sm:text-[9px]" aria-hidden="true"></i>
                      <span>{{ $link['label'] }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>

              @if ($title === 'Product')
                <a href="{{ url('/product') }}" class="mt-2 inline-flex items-center text-[12px] font-semibold text-white underline underline-offset-4 sm:mt-4 sm:text-[13px]">
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
  <div class="site-footer__legal site-container relative z-10 !px-5 sm:!px-6 lg:!px-8">
    <p class="leading-5">&copy; {{ $year }} Suave Creators. All Rights Reserved.</p>
    <p class="flex flex-wrap items-center gap-x-2 gap-y-1">
      <a href="{{ url('/privacy-policy') }}" class="inline-flex items-center py-1 hover:text-white sm:py-0">Privacy Policy</a>
      <span class="text-white/30" aria-hidden="true">|</span>
      <a href="{{ url('/terms-and-conditions') }}" class="inline-flex items-center py-1 hover:text-white sm:py-0">Terms &amp; Conditions</a>
    </p>
  </div>
  <a href="{{ url('/contact-us') }}" class="floating-chat" aria-label="Chat with us">
    <img src="/images/chat.svg" alt="">
  </a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@vite(['resources/js/app.js'])
@stack('scripts')
