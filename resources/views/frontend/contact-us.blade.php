@extends('layouts.frontend')

@section('content')
<!-- Contact Hero Start -->
<section class="relative z-10 w-full overflow-hidden pb-12 pt-8 sm:pb-16 sm:pt-10 lg:min-h-[580px] lg:pb-20 lg:pt-[52px] site-container">
  <div class="pointer-events-none absolute -right-24 top-10 h-72 w-72 rounded-full bg-[#7A5FF8]/20 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -bottom-32 left-1/3 h-72 w-72 rounded-full bg-[#2A4DFB]/20 blur-3xl" aria-hidden="true"></div>

  <div class="relative grid items-center gap-12 lg:grid-cols-[1.08fr_0.92fr] lg:gap-16">
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
  class="full-bleed scroll-mt-6 overflow-hidden bg-cover bg-center py-12 sm:py-16 lg:py-20"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');"
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
          <a class="contact-form-panel__meta-card" href="tel:+919736900142">
            <span class="contact-form-panel__meta-label">Phone</span>
            <span class="contact-form-panel__meta-value">+91 97369 00142</span>
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

          @if (session('status'))
            <p class="contact-form-panel__flash" role="status">{{ session('status') }}</p>
          @endif

          @if ($errors->any())
            <div class="contact-form-panel__errors" role="alert">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('contact-us.store') }}" method="post" class="contact-form-panel__fields" data-contact-form>
            @csrf
            <input type="hidden" name="form_started_at" value="{{ old('form_started_at', $formStartedAt ?? time()) }}">
            <div class="contact-form-honeypot" aria-hidden="true">
              <label for="contact-website">Website</label>
              <input id="contact-website" type="text" name="website" value="" tabindex="-1" autocomplete="off">
            </div>

            <div class="contact-form-panel__row">
              <label for="contact-name">
                <span class="contact-form-panel__label-text">Full name</span>
                <input id="contact-name" name="name" type="text" autocomplete="name" required placeholder="Jane Cooper" value="{{ old('name') }}">
              </label>
              <label for="contact-email">
                <span class="contact-form-panel__label-text">Email</span>
                <input id="contact-email" name="email" type="email" autocomplete="email" required placeholder="you@company.com" value="{{ old('email') }}">
              </label>
            </div>

            <div class="contact-form-panel__row">
              <label for="contact-phone">
                <span class="contact-form-panel__label-text">Phone</span>
                <input id="contact-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required placeholder="+91 90000 00000" value="{{ old('phone') }}">
              </label>
              <label for="contact-service">
                <span class="contact-form-panel__label-text">Service</span>
                <select id="contact-service" name="service" required>
                  <option value="" disabled @selected(old('service') === null || old('service') === '')>Select a service</option>
                  @foreach ($formServices as $value => $label)
                    <option value="{{ $value }}" @selected(old('service') === $value)>{{ $label }}</option>
                  @endforeach
                </select>
              </label>
            </div>

            <label for="contact-message" class="contact-form-panel__message">
              <span class="contact-form-panel__label-text">What are you trying to fix?</span>
              <textarea id="contact-message" name="message" rows="3" minlength="10" required
                placeholder="A sentence or two about the problem is enough.">{{ old('message') }}</textarea>
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
              <a href="tel:+919736900142">or call +91 97369 00142</a>
            </div>

            <p class="contact-form-panel__disclaimer">
              Reply within 1 business day.
              <a href="{{ route('privacy-policy') }}">Privacy policy</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Contact Form End -->

<!-- Technologies & Partnerships Marquee Start -->
<x-frontend.tech-partnerships-section
  :items="$techStack"
  section-class="full-bleed full-bleed--edge bg-white py-10 lg:py-14"
  background-image="assets/background/technology-section-bg.png"
/>
<!-- Technologies & Partnerships Marquee End -->

<!-- Contact Information Start -->
<section class="full-bleed bg-cover bg-center py-16 sm:py-20 lg:py-24"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');"
  aria-labelledby="contact-details-heading">
  <div class="section-inner">
    <header class="mx-auto max-w-[680px] text-center">
      <p
        class="offerings-eyebrow inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-[14px] font-bold leading-[100%] text-transparent">
        Prefer another way to reach us?
      </p>
      <h2 id="contact-details-heading" class="mt-4 text-2xl font-semibold text-[#171717]">
        We’re always within reach
      </h2>
      <p class="mx-auto mt-4 max-w-[560px] text-sm leading-6 text-[#4D4D4D]">
        Visit, email, or call us. Choose whichever way works best for you.
      </p>
    </header>

    <div class="mt-10 grid gap-5 md:grid-cols-3 lg:mt-14">
      @foreach ($contactCards as $index => $card)
        <article class="group relative overflow-hidden rounded-[24px] border border-[#E5E8F5] bg-white p-7 shadow-[0_16px_40px_rgba(31,34,88,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_55px_rgba(31,34,88,0.11)] sm:p-8">
          <span class="absolute right-5 top-3 text-[64px] font-extrabold leading-none text-[#F2F4FD]" aria-hidden="true">0{{ $index + 1 }}</span>
          <span class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#EEF1FF] to-[#E7E8FF] text-xl text-[#2A4DFB] transition group-hover:from-[#2A4DFB] group-hover:to-[#7158F5] group-hover:text-white">
            <i class="{{ $card['icon'] }}" aria-hidden="true"></i>
          </span>
          <p class="relative mt-7 text-xs font-bold uppercase tracking-[0.12em] text-[#858899]">{{ $card['label'] }}</p>
          <h3 class="relative mt-2 text-xl font-semibold text-[#171717]">{{ $card['title'] }}</h3>
          <div class="relative mt-5 border-t border-[#ECEEF7] pt-5 text-sm leading-6 text-[#4D4D4D]">
            @foreach ($card['lines'] as $line)
              <p>{{ $line }}</p>
            @endforeach
            @foreach ($card['links'] as $link)
              <a href="{{ $link['href'] }}" class="block min-h-8 font-semibold text-[#303241] transition hover:text-[#2A4DFB]">
                {{ $link['text'] }}
              </a>
            @endforeach
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
<!-- Contact Information End -->

<x-frontend.faq-section
  class="faq-section--align faq-section--contact bg-cover bg-center"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');"
  heading-id="contact-faq-heading"
  eyebrow="Questions before you get started?"
  title="Frequently Ask Question"
  description="Here are the most asked questions based on feedback from our users."
  :qa="$faqs"
  :media="$faqMedia"
  media-type="image"
  :media-alt="$faqMediaAlt"
  :cta-href="$faqCtaHref"
  :cta-label="$faqCtaLabel"
/>
@endsection
