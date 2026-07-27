<section id="consultation" {{ $attributes->merge(['class' => 'full-bleed consultation-section']) }}>
  <div class="section-inner">
    <div
      class="consultation-card bg-cover bg-top bg-no-repeat{{ $solo ? ' consultation-card--solo' : '' }}"
      style="background-image: url('{{ asset($backgroundImage) }}');">
      <div class="consultation-copy">
        <h2>
          @if ($allowHtmlTitle)
            {!! $title !!}
          @else
            {{ $title }}
          @endif
        </h2>
        <p>{{ $description }}</p>
        <div class="flex flex-wrap gap-4">
          <a href="{{ $ctaHref }}" class="consultation-cta">
            {{ $ctaLabel }}
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">
              <path d="M18 8L22 12L18 16"></path>
              <path d="M2 12H22"></path>
            </svg>
          </a>
          @if ($secondaryCtaLabel !== '')
            <a href="{{ $secondaryCtaHref }}" class="consultation-cta consultation-cta--secondary">
              {{ $secondaryCtaLabel }}
            </a>
          @endif
        </div>
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
          <div class="consultation-people__column">
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
