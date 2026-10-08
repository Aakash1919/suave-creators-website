@php
  $titleParts = $titleParts();
@endphp

<section
  @if ($sectionId !== '') id="{{ $sectionId }}" @endif
  {{ $attributes->merge(['class' => 'full-bleed marketing-services-overview']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner marketing-services-overview__inner">
    <header class="marketing-services-overview__header">
      <h2 id="{{ $headingId }}" class="marketing-services-overview__title">
        {{ $titleParts['before'] }}@if ($titleParts['accent'] !== '')<span class="marketing-services-overview__title-accent">{{ $titleParts['accent'] }}</span>{{ $titleParts['after'] }}@endif
      </h2>

      @if ($description !== '')
        <p class="marketing-services-overview__desc">{{ $description }}</p>
      @endif
    </header>

    @if ($rows !== [])
      <div class="marketing-services-overview__cards">
        @foreach ($rows as $row)
          @php
            $anchor = trim((string) ($row['anchor'] ?? ''));
            $service = (string) ($row['service'] ?? '');
          @endphp
          <article class="marketing-services-overview__card">
            <h3 class="marketing-services-overview__card-title">
              @if ($anchor !== '')
                <a href="#{{ $anchor }}" class="marketing-services-overview__service-link">{{ $service }}</a>
              @else
                {{ $service }}
              @endif
            </h3>
            <dl class="marketing-services-overview__card-list">
              <div class="marketing-services-overview__card-row">
                <dt>What it does</dt>
                <dd>{{ $row['does'] ?? '' }}</dd>
              </div>
              <div class="marketing-services-overview__card-row">
                <dt>Best for</dt>
                <dd>{{ $row['bestFor'] ?? '' }}</dd>
              </div>
              <div class="marketing-services-overview__card-row">
                <dt>How it's measured</dt>
                <dd>{{ $row['measured'] ?? '' }}</dd>
              </div>
            </dl>
          </article>
        @endforeach
      </div>

      <div class="marketing-services-overview__panel">
        <table class="marketing-services-overview__table">
          @if ($columns !== [])
            <thead>
              <tr>
                @foreach ($columns as $column)
                  <th scope="col">{{ $column }}</th>
                @endforeach
              </tr>
            </thead>
          @endif
          <tbody>
            @foreach ($rows as $row)
              @php
                $anchor = trim((string) ($row['anchor'] ?? ''));
                $service = (string) ($row['service'] ?? '');
              @endphp
              <tr>
                <th scope="row">
                  @if ($anchor !== '')
                    <a href="#{{ $anchor }}" class="marketing-services-overview__service-link">{{ $service }}</a>
                  @else
                    {{ $service }}
                  @endif
                </th>
                <td>{{ $row['does'] ?? '' }}</td>
                <td>{{ $row['bestFor'] ?? '' }}</td>
                <td>{{ $row['measured'] ?? '' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</section>
