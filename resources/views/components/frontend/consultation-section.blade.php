<section id="consultation" {{ $attributes->merge(['class' => 'full-bleed consultation-section']) }}>
  <div class="section-inner">
    <div
      class="consultation-card bg-cover bg-no-repeat{{ $cardPosition === 'center' ? ' bg-center' : ' bg-top' }}{{ $solo ? ' consultation-card--solo' : '' }}"
      style="background-image: url('{{ asset($backgroundImage) }}');">
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
        <div class="flex flex-wrap gap-4">
          <a href="{{ $ctaHref }}" class="consultation-cta">
            {{ $ctaLabel }}
            <x-frontend.cta-arrow />
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
