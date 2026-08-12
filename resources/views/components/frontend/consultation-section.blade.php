<section id="consultation" {{ $attributes->merge(['class' => 'full-bleed consultation-section']) }}>
  <div class="section-inner">
    <div
      class="consultation-card bg-cover bg-no-repeat{{ $cardPosition === 'center' ? ' bg-center' : ' bg-top' }}{{ $solo ? ' consultation-card--solo' : '' }}{{ $hideBgBelowDesktop ? ' consultation-card--hide-bg-below-desktop' : '' }}"
      @if ($hideBgBelowDesktop)
        style="--consultation-bg: url('{{ asset($backgroundImage) }}');"
      @else
        style="background-image: url('{{ asset($backgroundImage) }}');"
      @endif
    >
      <div class="consultation-copy">
        @if ($eyebrow !== '')
          <span class="mb-2 inline-block text-sm font-semibold text-white/80">{{ $eyebrow }}</span>
        @endif
        <h2>
          @if ($allowHtmlTitle)
            {!! $title !!}
          @else
            {{ $title }}
          @endif
        </h2>
        <p>{{ $description }}</p>
        @if ($secondaryCtaLabel !== '')
          <div class="flex flex-wrap gap-4">
            <a href="{{ $ctaHref }}"
              @if (str_starts_with($ctaHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
              class="group consultation-cta cursor-pointer">
              {{ $ctaLabel }}
              <x-frontend.cta-arrow />
            </a>
            <a href="{{ $secondaryCtaHref }}"
              @if (str_starts_with($secondaryCtaHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
              class="consultation-secondary-link inline-flex cursor-pointer items-end border-b border-white/70 pb-0.5 text-sm font-semibold text-white">
              {{ $secondaryCtaLabel }}
            </a>
          </div>
        @else
          <a href="{{ $ctaHref }}"
            @if (str_starts_with($ctaHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
            class="group consultation-cta cursor-pointer">
            {{ $ctaLabel }}
            <x-frontend.cta-arrow />
          </a>
        @endif
      </div>

      @if ($showPeople && count($people) > 0)
        @php($columns = $peopleByColumn())
        <div class="consultation-people">
          <div class="consultation-people__column consultation-people__column--left">
            @foreach ($columns['left'] as $person)
              <figure class="consultation-person consultation-person--{{ $person['tone'] }}">
                <img src="{{ asset($person['src']) }}" alt="{{ $person['alt'] }}" title="{{ $person['alt'] }}"
                  width="640" height="960" loading="lazy" decoding="async">
              </figure>
            @endforeach
          </div>
          <div class="consultation-people__column consultation-people__column--center">
            @foreach ($columns['center'] as $person)
              <figure class="consultation-person consultation-person--{{ $person['tone'] }}">
                <img src="{{ asset($person['src']) }}" alt="{{ $person['alt'] }}" title="{{ $person['alt'] }}"
                  width="640" height="960" loading="lazy" decoding="async">
              </figure>
            @endforeach
          </div>
          <div class="consultation-people__column consultation-people__column--right">
            @foreach ($columns['right'] as $person)
              <figure class="consultation-person consultation-person--{{ $person['tone'] }}">
                <img src="{{ asset($person['src']) }}" alt="{{ $person['alt'] }}" title="{{ $person['alt'] }}"
                  width="640" height="960" loading="lazy" decoding="async">
              </figure>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</section>
