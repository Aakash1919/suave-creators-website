<section
  {{ $attributes->merge(['class' => 'full-bleed marketing-radar-hero']) }}
  @if (filled($backgroundImage))
    style="background-image: url('{{ asset($backgroundImage) }}')"
  @endif
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner marketing-radar-hero__inner">
    <nav class="marketing-radar-hero__breadcrumb" aria-label="Breadcrumb">
      <ol class="marketing-radar-hero__breadcrumb-list">
        <li>
          <a href="{{ route('home') }}" class="marketing-radar-hero__breadcrumb-link">
            <i class="fa-solid fa-house" aria-hidden="true"></i>
            <span class="sr-only">Home</span>
          </a>
        </li>
        <li aria-hidden="true" class="marketing-radar-hero__breadcrumb-sep">›</li>
        <li>
          <a href="{{ route('services') }}" class="marketing-radar-hero__breadcrumb-link">Services</a>
        </li>
        <li aria-hidden="true" class="marketing-radar-hero__breadcrumb-sep">›</li>
        <li>
          <span class="marketing-radar-hero__breadcrumb-current" aria-current="page">{{ $breadcrumbCurrent }}</span>
        </li>
      </ol>
    </nav>

    <div class="marketing-radar-hero__grid">
      <div class="marketing-radar-hero__copy">
        <p class="marketing-radar-hero__eyebrow">
          <span class="marketing-radar-hero__eyebrow-text">{{ $eyebrow }}</span>
        </p>

        <h1 id="{{ $headingId }}" class="page-hero-title marketing-radar-hero__title">
          <span class="marketing-radar-hero__title-lead">{{ $title['lead'] }}</span>
          <span class="marketing-radar-hero__title-line">
            <span class="marketing-radar-hero__title-accent">{{ $title['accent'] }}</span>
            <span class="marketing-radar-hero__title-soft">{{ $title['soft'] }}</span>
          </span>
        </h1>

        <p class="marketing-radar-hero__desc">{{ $description }}</p>

        <div class="marketing-radar-hero__cta">
          <a
            href="#contact-modal"
            class="marketing-radar-hero__cta-primary"
            data-open-contact-modal
            data-service="{{ $primaryService }}">
            {{ $primaryLabel }}
            <span class="marketing-radar-hero__cta-primary-arrow" aria-hidden="true">→</span>
          </a>
          <a href="{{ route('services') }}" class="marketing-radar-hero__cta-secondary">
            {{ $secondaryLabel }}
            <span class="marketing-radar-hero__cta-play" aria-hidden="true">
              <img
                src="{{ asset('assets/icons/arrow-down-circle-icon.svg') }}"
                alt="Down arrow circle icon for digital marketing services CTA"
                title="Down arrow circle icon for digital marketing services CTA"
                width="28"
                height="28"
                decoding="async">
            </span>
          </a>
        </div>
      </div>

      <div class="marketing-radar-hero__visual">
        @if (filled($visualImage))
          <img
            class="marketing-radar-hero__visual-img"
            src="{{ asset($visualImage) }}"
            alt="{{ $visualAlt }}"
            title="{{ $visualAlt }}"
            width="920"
            height="780"
            loading="eager"
            decoding="async"
            fetchpriority="high">
        @else
          <span
            class="marketing-radar-hero__visual-placeholder"
            role="img"
            aria-label="{{ $visualAlt }}"></span>
        @endif
      </div>
    </div>

    @if ($proofPoints !== [])
      <div class="marketing-radar-hero__proof">
        <ul class="marketing-radar-hero__proof-list">
          @foreach ($proofPoints as $point)
            <li class="marketing-radar-hero__proof-item">
              <span class="marketing-radar-hero__proof-check" aria-hidden="true">
                <i class="fa-solid fa-check"></i>
              </span>
              <span>{{ $point }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
</section>
