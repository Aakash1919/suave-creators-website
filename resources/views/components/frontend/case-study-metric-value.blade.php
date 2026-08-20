@if ($parsed['numeric'])
  <{{ $tag }}
    {{ $attributes->merge([
      'data-metric-counter' => '',
      'style' => 'min-width: '.max(strlen($parsed['raw']), 2).'ch',
    ]) }}
    data-counter-end="{{ $parsed['decimals'] > 0 ? number_format($parsed['end'], $parsed['decimals'], '.', '') : (int) $parsed['end'] }}"
    data-counter-decimals="{{ $parsed['decimals'] }}"
    data-counter-pad="{{ $parsed['pad'] }}"
    data-counter-prefix="{{ $parsed['prefix'] }}"
    data-counter-suffix="{{ $parsed['suffix'] }}"
    aria-label="{{ $parsed['raw'] }}"
  >{{ $parsed['prefix'] }}{{ $initial }}{{ $parsed['suffix'] }}</{{ $tag }}>
@else
  <{{ $tag }} {{ $attributes }}>{{ $parsed['raw'] }}</{{ $tag }}>
@endif

@once
@push('scripts')
<script>
  (function () {
    function prefersReducedMotion() {
      return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    function formatNumber(value, decimals, pad) {
      var text = decimals > 0 ? value.toFixed(decimals) : String(Math.round(value));
      if (pad > 1 && decimals === 0) {
        while (text.length < pad) text = '0' + text;
      }
      return text;
    }

    function render(el, number) {
      var prefix = el.getAttribute('data-counter-prefix') || '';
      var suffix = el.getAttribute('data-counter-suffix') || '';
      var decimals = parseInt(el.getAttribute('data-counter-decimals'), 10) || 0;
      var pad = parseInt(el.getAttribute('data-counter-pad'), 10) || 0;
      el.textContent = prefix + formatNumber(number, decimals, pad) + suffix;
    }

    function animate(el) {
      var end = parseFloat(el.getAttribute('data-counter-end')) || 0;
      if (prefersReducedMotion()) {
        render(el, end);
        return;
      }

      var duration = 1600;
      var startTime = null;

      function step(timestamp) {
        if (!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        render(el, progress === 1 ? end : end * eased);
        if (progress < 1) requestAnimationFrame(step);
      }

      requestAnimationFrame(step);
    }

    function watch(el) {
      if (el.getAttribute('data-counter-played') === '1') return;

      if (!('IntersectionObserver' in window)) {
        el.setAttribute('data-counter-played', '1');
        animate(el);
        return;
      }

      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          if (entry.target.getAttribute('data-counter-played') === '1') return;
          entry.target.setAttribute('data-counter-played', '1');
          animate(entry.target);
          observer.unobserve(entry.target);
        });
      }, { threshold: 0.4 });

      observer.observe(el);
    }

    function boot() {
      document.querySelectorAll('[data-metric-counter]').forEach(watch);
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
