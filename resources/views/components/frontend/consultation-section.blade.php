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
          <span class="consultation-eyebrow">{{ $eyebrow }}</span>
        @endif
        <h2>
          @if ($allowHtmlTitle)
            {!! $title !!}
          @else
            {{ $title }}
          @endif
        </h2>
        <p>{{ $description }}</p>
        <div class="mt-6">
          <x-frontend.inline-consultation-form
            theme="light"
            placeholder="Enter your phone or email"
            button-text="Get Free Consultation"
            :secondary-href="$secondaryCtaLabel !== '' ? $secondaryCtaHref : ($ctaHref !== '' ? $ctaHref : '')"
            :secondary-label="$secondaryCtaLabel !== '' ? $secondaryCtaLabel : ''" />
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
