@props([
    'tone' => 'blue',
    'delay' => 0,
])

@php
    $tone = in_array($tone, ['blue', 'purple', 'teal', 'orange'], true) ? $tone : 'blue';

    $palettes = [
        'blue' => '#2A4DFB',
        'purple' => '#7A5FF8',
        'teal' => '#14B8A6',
        'orange' => '#F97316',
    ];

    $charts = [
        'blue' => [
            'viewBox' => '0 0 275 170',
            'line' => 'M0.0 124.0 L2.0 123.0 L12.0 133.0 L18.0 127.0 L22.0 127.0 L28.0 134.0 L40.0 131.0 L50.0 124.0 L56.0 112.0 L60.0 115.0 L66.0 110.0 L72.0 89.0 L76.0 88.0 L80.0 79.0 L86.0 85.0 L92.0 79.0 L104.0 85.0 L116.0 68.0 L122.0 77.0 L124.0 74.0 L128.0 78.0 L132.0 77.0 L140.0 73.0 L144.0 58.0 L154.0 49.0 L160.0 50.0 L170.0 45.0 L176.0 47.0 L188.0 27.0 L192.0 31.0 L194.0 29.0 L200.0 31.0 L212.0 20.0 L216.0 24.0 L224.0 21.0 L232.0 25.0 L238.0 19.0 L246.0 16.0 L250.0 9.0 L256.0 4.0 L264.0 0.0 L274.0 7.0',
            'fill' => 'M0.0 124.0 L2.0 123.0 L12.0 133.0 L18.0 127.0 L22.0 127.0 L28.0 134.0 L40.0 131.0 L50.0 124.0 L56.0 112.0 L60.0 115.0 L66.0 110.0 L72.0 89.0 L76.0 88.0 L80.0 79.0 L86.0 85.0 L92.0 79.0 L104.0 85.0 L116.0 68.0 L122.0 77.0 L124.0 74.0 L128.0 78.0 L132.0 77.0 L140.0 73.0 L144.0 58.0 L154.0 49.0 L160.0 50.0 L170.0 45.0 L176.0 47.0 L188.0 27.0 L192.0 31.0 L194.0 29.0 L200.0 31.0 L212.0 20.0 L216.0 24.0 L224.0 21.0 L232.0 25.0 L238.0 19.0 L246.0 16.0 L250.0 9.0 L256.0 4.0 L264.0 0.0 L274.0 7.0 L274.0 170 L0.0 170 Z',
        ],
        'purple' => [
            'viewBox' => '0 0 275 150',
            'line' => 'M0.0 113.0 L4.0 110.0 L12.0 114.0 L20.0 107.0 L28.0 108.0 L42.0 98.0 L50.0 98.0 L58.0 68.0 L60.0 68.0 L66.0 80.0 L76.0 86.0 L82.0 102.0 L84.0 102.0 L90.0 78.0 L94.0 79.0 L98.0 84.0 L110.0 79.0 L116.0 80.0 L126.0 73.0 L132.0 73.0 L138.0 59.0 L142.0 59.0 L146.0 62.0 L158.0 62.0 L164.0 77.0 L170.0 61.0 L180.0 55.0 L184.0 4.0 L186.0 5.0 L188.0 37.0 L196.0 44.0 L200.0 44.0 L216.0 28.0 L224.0 32.0 L230.0 26.0 L236.0 25.0 L242.0 11.0 L248.0 13.0 L264.0 7.0 L270.0 1.0 L274.0 0.0',
            'fill' => 'M0.0 113.0 L4.0 110.0 L12.0 114.0 L20.0 107.0 L28.0 108.0 L42.0 98.0 L50.0 98.0 L58.0 68.0 L60.0 68.0 L66.0 80.0 L76.0 86.0 L82.0 102.0 L84.0 102.0 L90.0 78.0 L94.0 79.0 L98.0 84.0 L110.0 79.0 L116.0 80.0 L126.0 73.0 L132.0 73.0 L138.0 59.0 L142.0 59.0 L146.0 62.0 L158.0 62.0 L164.0 77.0 L170.0 61.0 L180.0 55.0 L184.0 4.0 L186.0 5.0 L188.0 37.0 L196.0 44.0 L200.0 44.0 L216.0 28.0 L224.0 32.0 L230.0 26.0 L236.0 25.0 L242.0 11.0 L248.0 13.0 L264.0 7.0 L270.0 1.0 L274.0 0.0 L274.0 150 L0.0 150 Z',
        ],
        'teal' => [
            'viewBox' => '0 0 275 208',
            'line' => 'M0.0 154.0 L2.0 157.0 L8.0 154.0 L14.0 177.0 L18.0 182.0 L24.0 166.0 L28.0 184.0 L32.0 167.0 L40.0 167.0 L44.0 162.0 L46.0 164.0 L50.0 163.0 L56.0 146.0 L62.0 144.0 L64.0 140.0 L68.0 141.0 L72.0 134.0 L80.0 130.0 L84.0 135.0 L92.0 130.0 L96.0 139.0 L110.0 126.0 L114.0 125.0 L120.0 116.0 L124.0 116.0 L126.0 113.0 L138.0 109.0 L142.0 111.0 L148.0 110.0 L152.0 99.0 L156.0 96.0 L160.0 98.0 L166.0 96.0 L168.0 101.0 L172.0 98.0 L174.0 102.0 L180.0 100.0 L186.0 108.0 L190.0 108.0 L196.0 96.0 L204.0 68.0 L208.0 72.0 L212.0 63.0 L214.0 66.0 L220.0 68.0 L236.0 34.0 L246.0 33.0 L250.0 30.0 L254.0 7.0 L256.0 10.0 L262.0 4.0 L266.0 7.0 L270.0 7.0 L274.0 3.0',
            'fill' => 'M0.0 154.0 L2.0 157.0 L8.0 154.0 L14.0 177.0 L18.0 182.0 L24.0 166.0 L28.0 184.0 L32.0 167.0 L40.0 167.0 L44.0 162.0 L46.0 164.0 L50.0 163.0 L56.0 146.0 L62.0 144.0 L64.0 140.0 L68.0 141.0 L72.0 134.0 L80.0 130.0 L84.0 135.0 L92.0 130.0 L96.0 139.0 L110.0 126.0 L114.0 125.0 L120.0 116.0 L124.0 116.0 L126.0 113.0 L138.0 109.0 L142.0 111.0 L148.0 110.0 L152.0 99.0 L156.0 96.0 L160.0 98.0 L166.0 96.0 L168.0 101.0 L172.0 98.0 L174.0 102.0 L180.0 100.0 L186.0 108.0 L190.0 108.0 L196.0 96.0 L204.0 68.0 L208.0 72.0 L212.0 63.0 L214.0 66.0 L220.0 68.0 L236.0 34.0 L246.0 33.0 L250.0 30.0 L254.0 7.0 L256.0 10.0 L262.0 4.0 L266.0 7.0 L270.0 7.0 L274.0 3.0 L274.0 208 L0.0 208 Z',
        ],
        'orange' => [
            'viewBox' => '0 0 275 167',
            'line' => 'M0.0 121.0 L20.0 115.0 L28.0 104.0 L32.0 104.0 L36.0 112.0 L46.0 95.0 L50.0 110.0 L62.0 82.0 L66.0 79.0 L70.0 80.0 L80.0 93.0 L98.0 76.0 L104.0 98.0 L106.0 98.0 L110.0 89.0 L112.0 91.0 L116.0 85.0 L126.0 47.0 L130.0 43.0 L142.0 75.0 L146.0 73.0 L150.0 63.0 L156.0 68.0 L160.0 57.0 L164.0 59.0 L170.0 50.0 L172.0 50.0 L180.0 70.0 L190.0 62.0 L196.0 64.0 L204.0 26.0 L206.0 24.0 L212.0 30.0 L218.0 18.0 L222.0 16.0 L228.0 34.0 L232.0 32.0 L242.0 1.0 L246.0 1.0 L252.0 12.0 L256.0 4.0 L258.0 5.0 L260.0 14.0 L274.0 12.0',
            'fill' => 'M0.0 121.0 L20.0 115.0 L28.0 104.0 L32.0 104.0 L36.0 112.0 L46.0 95.0 L50.0 110.0 L62.0 82.0 L66.0 79.0 L70.0 80.0 L80.0 93.0 L98.0 76.0 L104.0 98.0 L106.0 98.0 L110.0 89.0 L112.0 91.0 L116.0 85.0 L126.0 47.0 L130.0 43.0 L142.0 75.0 L146.0 73.0 L150.0 63.0 L156.0 68.0 L160.0 57.0 L164.0 59.0 L170.0 50.0 L172.0 50.0 L180.0 70.0 L190.0 62.0 L196.0 64.0 L204.0 26.0 L206.0 24.0 L212.0 30.0 L218.0 18.0 L222.0 16.0 L228.0 34.0 L232.0 32.0 L242.0 1.0 L246.0 1.0 L252.0 12.0 L256.0 4.0 L258.0 5.0 L260.0 14.0 L274.0 12.0 L274.0 167 L0.0 167 Z',
        ],
    ];

    $color = $palettes[$tone];
    $chart = $charts[$tone];
    $delayMs = max(0, (int) $delay);
    $fillId = 'pcs-metric-fill-'.$tone.'-'.bin2hex(random_bytes(3));
@endphp

<div
  {{ $attributes->class([
    'product-case-study__metric-chart',
    'product-case-study__metric-chart--svg',
    'product-case-study__metric-chart--strip',
  ]) }}
  data-metric-chart
  data-metric-delay="{{ $delayMs }}"
  aria-hidden="true"
>
  <svg viewBox="{{ $chart['viewBox'] }}" preserveAspectRatio="none" fill="none" focusable="false">
    <defs>
      <linearGradient id="{{ $fillId }}" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stop-color="{{ $color }}" stop-opacity="0.42"/>
        <stop offset="100%" stop-color="{{ $color }}" stop-opacity="0"/>
      </linearGradient>
    </defs>
    <g class="product-case-study__metric-chart-area">
      <path class="product-case-study__metric-chart-fill" d="{{ $chart['fill'] }}" fill="url(#{{ $fillId }})"/>
    </g>
    <path
      class="product-case-study__metric-chart-line"
      data-metric-line
      d="{{ $chart['line'] }}"
      pathLength="1"
      stroke="{{ $color }}"
      stroke-width="2.2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <g class="product-case-study__metric-chart-dot">
      <circle r="4.2" fill="{{ $color }}"/>
    </g>
  </svg>
</div>

@once
@push('scripts')
<script>
  (function () {
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) return;

    var timers = [];
    var dashFrames = [];
    var dotFrames = [];

    function later(fn, delay) {
      timers.push(setTimeout(fn, delay));
    }

    function animateDash(path, duration, delay) {
      if (!path) return;
      path.style.strokeDasharray = '1';
      path.style.strokeDashoffset = '1';
      later(function () {
        var start = null;
        function step(ts) {
          if (!start) start = ts;
          var progress = Math.min((ts - start) / duration, 1);
          var eased = 1 - Math.pow(1 - progress, 3);
          path.style.strokeDashoffset = String(1 - eased);
          path.setAttribute('stroke-dashoffset', String(1 - eased));
          if (progress < 1) dashFrames.push(requestAnimationFrame(step));
        }
        dashFrames.push(requestAnimationFrame(step));
      }, delay);
    }

    function runDot(el) {
      var path = el.querySelector('[data-metric-line]');
      var dot = el.querySelector('.product-case-study__metric-chart-dot');
      if (!path || !dot || typeof path.getTotalLength !== 'function') return;

      var length = path.getTotalLength();
      if (!length) return;

      var duration = 8000;
      var start = null;

      function step(ts) {
        if (!start) start = ts;
        var t = ((ts - start) % duration) / duration;
        var point = path.getPointAtLength(t * length);
        dot.setAttribute('transform', 'translate(' + point.x + ',' + point.y + ')');
        dotFrames.push(requestAnimationFrame(step));
      }

      el.classList.add('is-glowing');
      dotFrames.push(requestAnimationFrame(step));
    }

    function play(root) {
      var charts = root.matches('[data-metric-chart]')
        ? [root]
        : Array.prototype.slice.call(root.querySelectorAll('[data-metric-chart]'));

      charts.forEach(function (el, index) {
        var delay = parseInt(el.getAttribute('data-metric-delay'), 10) || 0;
        later(function () {
          el.classList.add('is-playing');
          el.querySelectorAll('.product-case-study__metric-chart-line').forEach(function (path) {
            animateDash(path, 1350, 0);
          });
          later(function () {
            runDot(el);
          }, 1350);
        }, delay + index * 160);
      });
    }

    function boot() {
      var seen = [];
      document.querySelectorAll('[data-metric-chart]').forEach(function (el) {
        el.classList.add('is-armed');
        var root = el.closest('.case-study-visual--metrics, [data-outreach-hero]') || el;
        if (seen.indexOf(root) !== -1) return;
        seen.push(root);

        if (!('IntersectionObserver' in window)) {
          play(root);
          return;
        }

        var observer = new IntersectionObserver(function (entries) {
          entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            observer.unobserve(entry.target);
            play(entry.target);
          });
        }, { threshold: 0.35 });

        observer.observe(root);
      });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', boot);
    } else {
      boot();
    }
  })();
</script>
@endpush
@endonce
