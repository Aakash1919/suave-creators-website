@php
  $titleParts = $titleParts();
  $aiIcon = (string) ($aiVisibility['icon'] ?? '');
  $aiIconAlt = (string) ($aiVisibility['iconAlt'] ?? 'AI visibility icon for digital marketing discovery');
  $aiTitle = (string) ($aiVisibility['title'] ?? '');
  $aiBody = (string) ($aiVisibility['body'] ?? '');
  $stageThemes = ['awareness' => 'purple', 'consideration' => 'blue', 'decision' => 'green'];
@endphp

<section
  @if ($sectionId !== '') id="{{ $sectionId }}" @endif
  {{ $attributes->merge(['class' => 'full-bleed marketing-funnel-matrix']) }}
  @if (filled($backgroundImage))
    style="background-image: url('{{ asset($backgroundImage) }}')"
  @endif
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
          @php
            $stageKey = strtolower((string) ($row['stage'] ?? ''));
            $theme = (string) ($row['theme'] ?? ($stageThemes[$stageKey] ?? 'blue'));
            $stageIcon = (string) ($row['icon'] ?? '');
            $stageIconAlt = (string) ($row['iconAlt'] ?? (($row['stage'] ?? 'Buying stage').' icon for digital marketing funnel'));
          @endphp
          <article class="marketing-funnel-matrix__card marketing-funnel-matrix__card--{{ $theme }}">
            <header class="marketing-funnel-matrix__card-header">
              <span class="marketing-funnel-matrix__stage">
                <span class="marketing-funnel-matrix__stage-icon marketing-funnel-matrix__stage-icon--{{ $theme }}">
                  @if (filled($stageIcon))
                    <img
                      src="{{ asset($stageIcon) }}"
                      alt="{{ $stageIconAlt }}"
                      title="{{ $stageIconAlt }}"
                      width="40"
                      height="40"
                      loading="lazy"
                      decoding="async">
                  @else
                    <span
                      class="marketing-funnel-matrix__stage-icon-placeholder"
                      role="img"
                      aria-label="{{ $stageIconAlt }}"></span>
                  @endif
                </span>
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
                  @php
                    $columnLabel = is_array($column) ? (string) ($column['label'] ?? '') : (string) $column;
                    $columnIcon = is_array($column) ? (string) ($column['icon'] ?? '') : '';
                    $columnIconAlt = is_array($column)
                      ? (string) ($column['iconAlt'] ?? ($columnLabel.' icon for digital marketing funnel'))
                      : '';
                    $showColumnIcon = is_array($column) && array_key_exists('icon', $column);
                  @endphp
                  <th scope="col">
                    @if ($showColumnIcon)
                      <span class="marketing-funnel-matrix__col-label">
                        <span class="marketing-funnel-matrix__col-icon">
                          @if (filled($columnIcon))
                            <img
                              src="{{ asset($columnIcon) }}"
                              alt="{{ $columnIconAlt }}"
                              title="{{ $columnIconAlt }}"
                              width="18"
                              height="18"
                              loading="lazy"
                              decoding="async">
                          @else
                            <span
                              class="marketing-funnel-matrix__col-icon-placeholder"
                              role="img"
                              aria-label="{{ $columnIconAlt }}"></span>
                          @endif
                        </span>
                        <span>{{ $columnLabel }}</span>
                      </span>
                    @else
                      {{ $columnLabel }}
                    @endif
                  </th>
                @endforeach
              </tr>
            </thead>
          @endif
          <tbody>
            @foreach ($rows as $row)
              @php
                $stageKey = strtolower((string) ($row['stage'] ?? ''));
                $theme = (string) ($row['theme'] ?? ($stageThemes[$stageKey] ?? 'blue'));
                $stageIcon = (string) ($row['icon'] ?? '');
                $stageIconAlt = (string) ($row['iconAlt'] ?? (($row['stage'] ?? 'Buying stage').' icon for digital marketing funnel'));
              @endphp
              <tr>
                <th scope="row">
                  <span class="marketing-funnel-matrix__stage">
                    <span class="marketing-funnel-matrix__stage-icon marketing-funnel-matrix__stage-icon--{{ $theme }}">
                      @if (filled($stageIcon))
                        <img
                          src="{{ asset($stageIcon) }}"
                          alt="{{ $stageIconAlt }}"
                          title="{{ $stageIconAlt }}"
                          width="40"
                          height="40"
                          loading="lazy"
                          decoding="async">
                      @else
                        <span
                          class="marketing-funnel-matrix__stage-icon-placeholder"
                          role="img"
                          aria-label="{{ $stageIconAlt }}"></span>
                      @endif
                    </span>
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

    @if ($examples !== [] || $aiTitle !== '' || $aiBody !== '')
      <div class="marketing-funnel-matrix__summary">
        @if ($examples !== [])
          <div class="marketing-funnel-matrix__examples">
            @if ($examplesIntro !== '')
              <p class="marketing-funnel-matrix__examples-intro">{{ $examplesIntro }}</p>
            @endif
            @foreach ($examples as $example)
              @php
                $exampleIcon = (string) ($example['icon'] ?? '');
                $exampleIconAlt = (string) ($example['iconAlt'] ?? (($example['title'] ?? 'Example').' icon for digital marketing funnel'));
                $exampleTitle = (string) ($example['title'] ?? '');
                $exampleBody = (string) ($example['body'] ?? '');
                $exampleTheme = (string) ($example['theme'] ?? 'purple');
              @endphp
              <article class="marketing-funnel-matrix__example marketing-funnel-matrix__example--{{ $exampleTheme }}">
                <span class="marketing-funnel-matrix__example-icon marketing-funnel-matrix__example-icon--{{ $exampleTheme }}">
                  @if (filled($exampleIcon))
                    <img
                      src="{{ asset($exampleIcon) }}"
                      alt="{{ $exampleIconAlt }}"
                      title="{{ $exampleIconAlt }}"
                      width="48"
                      height="48"
                      loading="lazy"
                      decoding="async">
                  @else
                    <span
                      class="marketing-funnel-matrix__example-icon-placeholder"
                      role="img"
                      aria-label="{{ $exampleIconAlt }}"></span>
                  @endif
                </span>
                <div class="marketing-funnel-matrix__example-copy">
                  @if ($exampleTitle !== '')
                    <h3 class="marketing-funnel-matrix__example-title">{{ $exampleTitle }}</h3>
                  @endif
                  @if ($exampleBody !== '')
                    <p class="marketing-funnel-matrix__example-body">{{ $exampleBody }}</p>
                  @endif
                </div>
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
    @endif
  </div>
</section>
