@php
  $primary = $bento['primary'];
  $secondary = $bento['secondary'];
  $portrait = $bento['portrait'];
  $logo = $bento['logo'];
  $chip = $bento['chip'];
  $chartBars = $bento['chartBars'];
  $caseStudyHref = $bento['caseStudyHref'];
@endphp

<div {{ $attributes->class(['bento'])->merge(['data-bento' => '']) }}>
  <div class="bento__col bento__col--left">
    <a
      href="{{ $caseStudyHref }}"
      class="bento__card bento__card--metric bento__card--white bento__card--primary"
      data-bento-card
      data-bento-float="1">
      <div class="bento__card-inner">
        <div class="bento__metric-block">
          <x-frontend.case-study-metric-value
            class="bento__value"
            tag="p"
            :value="$primary['value']" />
          <p class="bento__label">{{ $primary['label'] }}</p>
        </div>
        <img
          src="{{ asset($logo['src']) }}"
          alt="{{ $logo['alt'] }}"
          title="{{ $logo['alt'] }}"
          class="bento__logo"
          width="{{ $logo['width'] }}"
          height="{{ $logo['height'] }}"
          decoding="async"
          loading="lazy"
          draggable="false">
      </div>
    </a>

    <div
      class="bento__card bento__card--chart bento__card--tint"
      data-bento-card
      data-bento-float="2"
      aria-hidden="true">
      <div class="bento__card-inner">
        <div class="bento__chart-panel">
          <div class="bento__chart" data-bento-chart>
            @foreach ($chartBars as $index => $height)
              <span
                class="bento__bar{{ $index === 3 ? ' bento__bar--peak' : '' }}"
                style="--bar-height: {{ $height }}%"></span>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bento__col bento__col--right">
    <div
      class="bento__card bento__card--portrait bento__card--tint"
      data-bento-card
      data-bento-float="3">
      <div class="bento__card-inner">
        <img
          src="{{ asset($portrait['src']) }}"
          alt="{{ $portrait['alt'] }}"
          title="{{ $portrait['alt'] }}"
          class="bento__portrait"
          width="{{ $portrait['width'] }}"
          height="{{ $portrait['height'] }}"
          decoding="async"
          loading="eager"
          fetchpriority="high"
          draggable="false">
      </div>
    </div>

    <a
      href="{{ $caseStudyHref }}"
      class="bento__card bento__card--metric bento__card--white bento__card--secondary"
      data-bento-card
      data-bento-float="4">
      <div class="bento__card-inner">
        <div class="bento__metric-block">
          <p class="bento__value-row">
            <x-frontend.case-study-metric-value
              class="bento__value"
              tag="span"
              :value="$secondary['value']" />
            <span class="bento__value-aside">{{ $secondary['label'] }}</span>
          </p>
          <p class="bento__label">{{ $secondary['sublabel'] }}</p>
        </div>
      </div>
    </a>

    <div
      class="bento__card bento__card--chip bento__card--tint"
      data-bento-card
      data-bento-float="5">
      <div class="bento__card-inner">
        <span class="bento__chip-icon" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 12a4.25 4.25 0 1 0 0-8.5 4.25 4.25 0 0 0 0 8.5Z" fill="currentColor"/>
            <path d="M4.5 19.25c.9-3.1 3.5-5 7.5-5s6.6 1.9 7.5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </span>
        <span class="bento__chip-label">{{ $chip['label'] }}</span>
      </div>
    </div>
  </div>
</div>

@once
@push('custom-css')
<style>
/* ===== BENTO START ===== */
.bento {
  --bento-radius: 22px;
  --bento-gap: 12px;
  --bento-white: #ffffff;
  --bento-tint: #f0eaff;
  --bento-accent: #2a4dfb;
  --bento-accent-soft: #7a5ff8;
  --bento-ink: #0f1222;
  --bento-muted: #6b728a;
  aspect-ratio: 670 / 540;
  display: grid;
  flex-shrink: 0;
  gap: var(--bento-gap);
  grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
  max-width: 670px;
  overflow: visible;
  width: 100%;
}

.bento__col {
  display: flex;
  flex-direction: column;
  gap: var(--bento-gap);
  min-height: 0;
  min-width: 0;
  overflow: visible;
}

.bento__col--left .bento__card--primary {
  flex: 1.05 1 0;
}

.bento__col--left .bento__card--chart {
  flex: 1.2 1 0;
}

.bento__col--right .bento__card--portrait {
  flex: 1.55 1 0;
  min-height: 0;
}

.bento__col--right .bento__card--secondary {
  flex: 0 0 auto;
}

.bento__col--right .bento__card--chip {
  flex: 0 0 auto;
}

.bento__card {
  border-radius: var(--bento-radius);
  cursor: grab;
  filter: blur(10px);
  min-height: 0;
  min-width: 0;
  opacity: 0;
  overflow: visible;
  position: relative;
  touch-action: none;
  transform: translateY(28px);
  transform-origin: center center;
  transform-style: preserve-3d;
  user-select: none;
  will-change: transform, opacity, filter;
  z-index: 1;
}

.bento__card.is-dragging {
  cursor: grabbing;
  z-index: 8;
}

.bento__card-inner {
  border-radius: inherit;
  height: 100%;
  overflow: hidden;
  transform-origin: center center;
  width: 100%;
  will-change: transform;
}

.bento.is-visible .bento__card[data-bento-float="1"] .bento__card-inner {
  animation: bento-float-1 11s 0.2s ease-in-out infinite;
}

.bento.is-visible .bento__card[data-bento-float="2"] .bento__card-inner {
  animation: bento-float-2 9s 0.35s ease-in-out infinite;
}

.bento.is-visible .bento__card[data-bento-float="3"] .bento__card-inner {
  animation: bento-float-3 13s 0.5s ease-in-out infinite;
}

.bento.is-visible .bento__card[data-bento-float="4"] .bento__card-inner {
  animation: bento-float-4 10s 0.65s ease-in-out infinite;
}

.bento.is-visible .bento__card[data-bento-float="5"] .bento__card-inner {
  animation: bento-float-5 12s 0.8s ease-in-out infinite;
}

.bento__card.is-dragging .bento__card-inner,
.bento__card.is-paused .bento__card-inner {
  animation-play-state: paused;
}

@keyframes bento-float-1 {
  0%, 100% { transform: translateY(0) translateX(0); }
  30% { transform: translateY(-5px) translateX(1.5px); }
  60% { transform: translateY(2px) translateX(-1px); }
}

@keyframes bento-float-2 {
  0%, 100% { transform: translateY(0) translateX(0); }
  25% { transform: translateY(6px) translateX(-1.5px); }
  55% { transform: translateY(-3px) translateX(1px); }
}

@keyframes bento-float-3 {
  0%, 100% { transform: translateY(0) translateX(0); }
  35% { transform: translateY(-6px) translateX(2px); }
  70% { transform: translateY(3px) translateX(-1px); }
}

@keyframes bento-float-4 {
  0%, 100% { transform: translateY(0) translateX(0); }
  40% { transform: translateY(5px) translateX(-2px); }
  75% { transform: translateY(-4px) translateX(1.5px); }
}

@keyframes bento-float-5 {
  0%, 100% { transform: translateY(0) translateX(0); }
  33% { transform: translateY(-4px) translateX(-1.5px); }
  66% { transform: translateY(3px) translateX(1px); }
}

.bento__card--white {
  background: transparent;
  color: var(--bento-ink);
}

.bento__card--white .bento__card-inner {
  background: var(--bento-white);
}

.bento__card--tint {
  background: transparent;
}

.bento__card--tint .bento__card-inner {
  background: var(--bento-tint);
}

.bento__card--primary .bento__card-inner {
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: space-between;
  padding: 1.15rem 1.2rem 1rem;
  text-decoration: none;
}

.bento__card--chart .bento__card-inner {
  align-items: center;
  display: flex;
  height: 100%;
  justify-content: center;
  padding: 1rem;
}

.bento__card--secondary .bento__card-inner {
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: center;
  padding: 1rem 1.15rem;
}

.bento__card--chip .bento__card-inner {
  align-items: center;
  display: flex;
  gap: 0.65rem;
  min-height: 3.25rem;
  padding: 0.75rem 1rem;
}

.bento__card--primary,
.bento__card--secondary {
  text-decoration: none;
}

.bento__metric-block {
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
}

.bento__value,
.bento__value [data-metric-counter] {
  color: var(--bento-ink);
  font-size: clamp(2rem, 4.2vw, 2.75rem);
  font-weight: 800;
  letter-spacing: -0.03em;
  line-height: 1;
  margin: 0;
}

.bento__value-row {
  align-items: baseline;
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem 0.55rem;
  margin: 0;
}

.bento__value-aside {
  color: var(--bento-ink);
  font-size: 1.05rem;
  font-weight: 700;
  line-height: 1.2;
}

.bento__label {
  color: var(--bento-muted);
  font-size: 0.875rem;
  font-weight: 500;
  line-height: 1.35;
  margin: 0;
}

.bento__logo {
  display: block;
  height: auto;
  margin-top: 0.85rem;
  max-width: 7.5rem;
  object-fit: contain;
  pointer-events: none;
  width: auto;
}

.bento__portrait {
  display: block;
  height: 100%;
  min-height: 100%;
  object-fit: cover;
  object-position: center top;
  pointer-events: none;
  width: 100%;
}

.bento__card--portrait .bento__card-inner {
  height: 100%;
}

.bento__chart-panel {
  background: var(--bento-white);
  border-radius: 18px;
  box-shadow: 0 10px 28px rgba(15, 18, 34, 0.08);
  height: 100%;
  max-height: 100%;
  padding: 1.1rem 1rem 0.85rem;
  width: 100%;
}

.bento__chart {
  align-items: flex-end;
  display: flex;
  gap: 0.55rem;
  height: 100%;
  justify-content: space-between;
  min-height: 7.5rem;
}

.bento__bar {
  background: linear-gradient(180deg, var(--bento-accent-soft) 0%, var(--bento-accent) 100%);
  border-radius: 999px 999px 6px 6px;
  display: block;
  flex: 1 1 0;
  height: var(--bar-height, 50%);
  max-width: 1.35rem;
  opacity: 0.92;
  position: relative;
  transform: scaleY(0);
  transform-origin: bottom center;
  will-change: transform;
}

.bento__bar::after {
  background: var(--bento-accent);
  border-radius: 50%;
  bottom: -0.2rem;
  content: "";
  height: 0.4rem;
  left: 50%;
  position: absolute;
  transform: translateX(-50%);
  width: 0.4rem;
}

.bento__bar--peak {
  opacity: 1;
}

.bento__chip-icon {
  align-items: center;
  color: var(--bento-accent);
  display: inline-flex;
  flex-shrink: 0;
  height: 1.25rem;
  justify-content: center;
  width: 1.25rem;
}

.bento__chip-label {
  color: var(--bento-ink);
  font-size: 0.95rem;
  font-weight: 600;
  line-height: 1.25;
}

@media (max-width: 1023px) {
  .bento {
    aspect-ratio: auto;
    max-width: 100%;
    min-height: 420px;
  }

  .bento__card--primary,
  .bento__card--secondary {
    min-height: 8.5rem;
  }

  .bento__col--right .bento__card--portrait {
    min-height: 220px;
  }

  .bento__chart {
    min-height: 8rem;
  }
}

@media (max-width: 639px) {
  .bento {
    --bento-radius: 18px;
    --bento-gap: 10px;
    aspect-ratio: auto;
    grid-template-columns: 1fr;
    min-height: 0;
  }

  .bento__col--right .bento__card--portrait {
    aspect-ratio: 4 / 3;
    flex: 0 0 auto;
    max-height: 280px;
  }

  .bento__value,
  .bento__value [data-metric-counter] {
    font-size: 2.15rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .bento__card,
  .bento__bar {
    cursor: default;
    filter: none;
    opacity: 1;
    touch-action: auto;
    transform: none;
    will-change: auto;
  }

  .bento__card-inner {
    animation: none !important;
  }
}
/* ===== BENTO END ===== */
</style>
@endpush

@push('scripts')
  @vite('resources/js/bento.js')
@endpush
@endonce
