<footer
  {{ $attributes->merge(['class' => 'site-footer overflow-x-clip text-white bg-cover bg-top bg-no-repeat']) }}
  style="background-image: url('{{ asset($backgroundImage) }}');"
>
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

  <div class="h-px bg-white/10" aria-hidden="true"></div>

  <div class="site-container relative z-10 !px-5 sm:!px-6 lg:!px-8">
    <div class="site-footer__main">
      <div class="site-footer__brand">
        <a href="{{ route('home') }}" class="inline-flex max-w-full" aria-label="Suave Creators home">
          <x-layouts.logo variant="footer" />
        </a>
        <p class="mt-3 text-[13px] font-medium leading-5 text-[#E4E9F8] sm:mt-5 sm:text-base">
          Web &amp; Software Development<br>
          <span class="mt-1 inline-block bg-gradient-to-b from-[#2F69FB] to-[#D078FE] bg-clip-text font-extrabold text-transparent">Solutions</span>
        </p>
        <ul class="site-footer__contact mt-4 space-y-1.5 text-[12px] font-medium text-[#E4E9F8] sm:mt-6 sm:space-y-3 sm:text-[13px]">
          <li>
            <a href="{{ $phoneHref }}" class="inline-flex !min-h-0 items-center py-1 hover:text-white sm:py-0">{{ $phone }}</a>
          </li>
          <li>
            <a href="mailto:{{ $emailHref }}" class="inline-flex !min-h-0 max-w-full items-center break-all py-1 hover:text-white sm:py-0">{{ $email }}</a>
          </li>
          <li class="leading-5">
            <div class="inline-block max-w-[280px] space-y-2 sm:max-w-none">
              @foreach ($offices as $office)
              @if($office['label'] != 'First office') 
              @else
                <p>
                  <span>{{ $office['display'] }}</span>
                </p>
                @endif
              @endforeach
            </div>
          </li>
        </ul>
      </div>

      <div class="min-w-0">
        <div class="site-footer__columns">
          @foreach ($columns as $title => $links)
            <div class="site-footer__column min-w-0">
              <h2 class="text-[11px] font-bold uppercase tracking-wide text-white sm:text-xs">
                {{ $title }}
              </h2>

              <ul class="mt-3 space-y-1.5 sm:mt-5 sm:space-y-3">
                @foreach ($links as $link)
                  <li>
                    <a href="{{ $link['href'] }}"
                      @if (str_starts_with($link['href'], 'http')) target="_blank" rel="noopener noreferrer" @endif
                      class="group flex !min-h-0 items-start gap-1.5 py-0.5 text-[13px] leading-4 text-[#E4E9F8] transition hover:text-white sm:gap-2 sm:py-0">
                      <i class="fa-solid fa-chevron-right mt-0.5 shrink-0 text-[8px] text-[#E4E9F8] transition-transform group-hover:translate-x-0.5 sm:text-[9px]"
                        aria-hidden="true"></i>
                      <span class="min-w-0 break-words">{{ $link['label'] }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>

              @if ($title === 'Product')
                <a href="{{ route('product') }}"
                  class="mt-2 inline-flex !min-h-0 items-center text-[12px] font-semibold text-white underline underline-offset-4 sm:mt-4 sm:text-[13px]">
                  Explore Suave Outreach CRM
                </a>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="footer-moving-line h-px" aria-hidden="true"></div>
  <div class="site-footer__legal site-container relative z-10 flex !px-5 flex-col gap-2 py-4 text-[13px] font-medium text-[#E4E9F8] sm:!px-6 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:py-5 lg:!px-8">
    <p class="leading-5">&copy; {{ $year }} Suave Creators. All Rights Reserved.</p>
    <p class="flex flex-wrap items-center gap-x-2 gap-y-1">
      <a href="{{ route('privacy-policy') }}" class="inline-flex !min-h-0 items-center py-1 text-[#E4E9F8] hover:text-white sm:py-0">Privacy Policy</a>
      <span class="text-white/40" aria-hidden="true">|</span>
      <a href="{{ route('terms-and-conditions') }}" class="inline-flex !min-h-0 items-center py-1 text-[#E4E9F8] hover:text-white sm:py-0">Terms &amp; Conditions</a>
    </p>
  </div>
</footer>
