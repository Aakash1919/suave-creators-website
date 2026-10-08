@php
  $titleParts = $titleParts();
  $aiIcon = (string) ($aiVisibility['icon'] ?? '');
  $aiIconAlt = (string) ($aiVisibility['iconAlt'] ?? 'AI visibility icon for digital marketing discovery');
  $aiTitle = (string) ($aiVisibility['title'] ?? '');
  $aiBody = (string) ($aiVisibility['body'] ?? '');
@endphp

<section
  @if ($sectionId !== '') id="{{ $sectionId }}" @endif
  {{ $attributes->merge(['class' => 'full-bleed marketing-funnel-matrix']) }}
  aria-labelledby="{{ $headingId }}">
  <div class="section-inner marketing-funnel-matrix__inner">
    <header class="marketing-funnel-matrix__header">
      <p class="marketing-funnel-matrix__eyebrow">
        <span class="marketing-funnel-matrix__eyebrow-bar" aria-hidden="true"></span>
        <span class="marketing-funnel-matrix__eyebrow-text">{{ $eyebrow }}</span>
      </p>

      <h2 id="{{ $headingId }}" class="marketing-funnel-matrix__title">
        {{ $titleParts['before'] }}@if ($titleParts['accent'] !== '')<span class="marketing-funnel-matrix__title-accent">{{ $titleParts['accent'] }}</span>{{ $titleParts['after'] }}@endif
      </h2>

      @if ($description !== '')
        <p class="marketing-funnel-matrix__desc">{{ $description }}</p>
      @endif
    </header>

    @if ($rows !== [])
      <div class="marketing-funnel-matrix__cards">
        @foreach ($rows as $row)
          <article class="marketing-funnel-matrix__card">
            <header class="marketing-funnel-matrix__card-header">
              <span class="marketing-funnel-matrix__stage">
                <span class="marketing-funnel-matrix__stage-index">{{ $row['index'] }}</span>
                <span class="marketing-funnel-matrix__stage-copy">
                  <span class="marketing-funnel-matrix__stage-name">{{ $row['stage'] }}</span>
                  <span class="marketing-funnel-matrix__stage-sub">{{ $row['subtitle'] }}</span>
                </span>
              </span>
            </header>
            <dl class="marketing-funnel-matrix__card-list">
              <div class="marketing-funnel-matrix__card-row">
                <dt>SEO</dt>
                <dd>{{ $row['seo'] }}</dd>
              </div>
              <div class="marketing-funnel-matrix__card-row">
                <dt>PPC</dt>
                <dd>{{ $row['ppc'] }}</dd>
              </div>
              <div class="marketing-funnel-matrix__card-row">
                <dt>Content</dt>
                <dd>{{ $row['content'] }}</dd>
              </div>
              <div class="marketing-funnel-matrix__card-row">
                <dt>Social</dt>
                <dd>{{ $row['social'] }}</dd>
              </div>
            </dl>
          </article>
        @endforeach
      </div>

      <div class="marketing-funnel-matrix__panel">
        <table class="marketing-funnel-matrix__table">
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
              <tr>
                <th scope="row">
                  <span class="marketing-funnel-matrix__stage">
                    <span class="marketing-funnel-matrix__stage-index">{{ $row['index'] }}</span>
                    <span class="marketing-funnel-matrix__stage-copy">
                      <span class="marketing-funnel-matrix__stage-name">{{ $row['stage'] }}</span>
                      <span class="marketing-funnel-matrix__stage-sub">{{ $row['subtitle'] }}</span>
                    </span>
                  </span>
                </th>
                <td>{{ $row['seo'] }}</td>
                <td>{{ $row['ppc'] }}</td>
                <td>{{ $row['content'] }}</td>
                <td>{{ $row['social'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    @if ($examples !== [])
      <div class="marketing-funnel-matrix__examples">
        @foreach ($examples as $example)
          <article class="marketing-funnel-matrix__example">
            <span class="marketing-funnel-matrix__example-index" aria-hidden="true">{{ $example['index'] }}</span>
            <p class="marketing-funnel-matrix__example-body">{{ $example['body'] }}</p>
          </article>
        @endforeach
      </div>
    @endif

    @if ($aiTitle !== '' || $aiBody !== '')
      <aside class="marketing-funnel-matrix__ai">
        <div class="marketing-funnel-matrix__ai-icon">
          @if (filled($aiIcon))
            <img
              src="{{ asset($aiIcon) }}"
              alt="{{ $aiIconAlt }}"
              title="{{ $aiIconAlt }}"
              width="48"
              height="48"
              loading="lazy"
              decoding="async">
          @else
            <span
              class="marketing-funnel-matrix__ai-icon-placeholder"
              role="img"
              aria-label="{{ $aiIconAlt }}"></span>
          @endif
        </div>
        <div class="marketing-funnel-matrix__ai-copy">
          @if ($aiTitle !== '')
            <h3 class="marketing-funnel-matrix__ai-title">{{ $aiTitle }}</h3>
          @endif
          @if ($aiBody !== '')
            <p class="marketing-funnel-matrix__ai-body">{{ $aiBody }}</p>
          @endif
        </div>
      </aside>
    @endif
  </div>
</section>
