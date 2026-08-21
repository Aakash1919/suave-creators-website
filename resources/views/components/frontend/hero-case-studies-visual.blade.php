@if ($scene)
  @php
    $caseHref = ($scene['url'] ?? '') !== '' ? (string) $scene['url'] : route('case-studies');
    $hasChartImage = ! empty($scene['chart_image']);
    $bars = is_array($scene['bars'] ?? null) ? $scene['bars'] : [42, 68, 92, 58, 76];
  @endphp
  <div
    class="hero-cs-visual"
    data-hero-cs-visual>
    <script type="application/json" data-hero-cs-scenes-json>{!! json_encode($scenes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    <div class="hero-cs-visual__poster" data-hero-cs-poster>
      <img
        src="{{ $scene['photo_image'] }}"
        alt="{{ $scene['alt'] }}"
        title="{{ $scene['alt'] }}"
        class="hero-cs-visual__poster-img"
        width="400"
        height="400"
        decoding="async"
        loading="eager"
        fetchpriority="high">
    </div>

    <div
      class="hero-cs-visual__stage opacity-0"
      data-hero-cs-stage
      aria-label="Featured case study results">
      <div class="hero-cs-visual__mosaic" data-hero-cs-mosaic>
        <a
          href="{{ $caseHref }}"
          class="hero-cs-visual__tile hero-cs-visual__tile--metric"
          data-hero-cs-tile="0"
          data-hero-cs-link
          style="--hero-cs-i: 0"
          aria-label="{{ $scene['title'] }}: {{ $scene['primary']['value'] }} {{ $scene['primary']['label_short'] }}">
          <span class="hero-cs-visual__fade" data-hero-cs-fade>
            <span class="hero-cs-visual__metric-value" data-hero-cs-primary-value>{{ $scene['primary']['value'] }}</span>
            <span class="hero-cs-visual__metric-label" data-hero-cs-primary-label>{{ $scene['primary']['label_short'] }}</span>
            <span class="hero-cs-visual__brand">
              <img
                src="{{ $scene['brand_image'] }}"
                alt="{{ $scene['alt'] }}"
                title="{{ $scene['alt'] }}"
                class="hero-cs-visual__brand-mark"
                data-hero-cs-brand
                width="72"
                height="28"
                decoding="async"
                loading="eager">
            </span>
          </span>
        </a>

        <a
          href="{{ $caseHref }}"
          class="hero-cs-visual__tile hero-cs-visual__tile--photo"
          data-hero-cs-tile="1"
          data-hero-cs-link
          style="--hero-cs-i: 1"
          aria-label="{{ $scene['title'] }}"
          data-hero-cs-photo-label>
          <span class="hero-cs-visual__fade" data-hero-cs-fade>
            <img
              src="{{ $scene['photo_image'] }}"
              alt="{{ $scene['alt'] }}"
              title="{{ $scene['alt'] }}"
              class="hero-cs-visual__photo-img"
              data-hero-cs-photo
              width="200"
              height="220"
              decoding="async"
              loading="eager">
          </span>
        </a>

        <a
          href="{{ $caseHref }}"
          class="hero-cs-visual__tile hero-cs-visual__tile--chart{{ $hasChartImage ? ' has-chart-image' : '' }}"
          data-hero-cs-tile="2"
          data-hero-cs-link
          data-hero-cs-chart-tile
          style="--hero-cs-i: 2"
          aria-label="{{ $scene['title'] }} results chart">
          <span class="hero-cs-visual__fade" data-hero-cs-fade>
            <span class="hero-cs-visual__chart-panel" data-hero-cs-bars aria-hidden="true">
              @foreach ($bars as $index => $height)
                <span
                  class="hero-cs-visual__bar{{ $index === 2 ? ' is-active' : '' }}"
                  data-hero-cs-bar
                  style="--hero-cs-bar: {{ (int) $height }}%"></span>
              @endforeach
            </span>
            <img
              src="{{ $hasChartImage ? $scene['chart_image'] : $scene['photo_image'] }}"
              alt="{{ $scene['alt'] }}"
              title="{{ $scene['alt'] }}"
              class="hero-cs-visual__chart-img"
              data-hero-cs-chart-img
              width="200"
              height="160"
              decoding="async"
              loading="lazy"
              @if (! $hasChartImage) hidden @endif>
          </span>
        </a>

        <div class="hero-cs-visual__stack">
          <a
            href="{{ $caseHref }}"
            class="hero-cs-visual__tile hero-cs-visual__tile--metric-sm"
            data-hero-cs-tile="3"
            data-hero-cs-link
            style="--hero-cs-i: 3"
            aria-label="{{ $scene['title'] }}: {{ $scene['secondary']['value'] }} {{ $scene['secondary']['label_short'] }}">
            <span class="hero-cs-visual__fade" data-hero-cs-fade>
              <span class="hero-cs-visual__metric-value hero-cs-visual__metric-value--sm" data-hero-cs-secondary-value>{{ $scene['secondary']['value'] }}</span>
              <span class="hero-cs-visual__metric-label" data-hero-cs-secondary-label>{{ $scene['secondary']['label_short'] }}</span>
            </span>
          </a>

          <a
            href="{{ $caseHref }}"
            class="hero-cs-visual__tile hero-cs-visual__tile--tag"
            data-hero-cs-tile="4"
            data-hero-cs-link
            style="--hero-cs-i: 4"
            aria-label="{{ $scene['tag'] }}">
            <span class="hero-cs-visual__fade hero-cs-visual__fade--row" data-hero-cs-fade>
              <span class="hero-cs-visual__tag-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-width="1.8"/>
                  <path d="M5.5 18.5c1.4-2.6 3.5-3.9 6.5-3.9s5.1 1.3 6.5 3.9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
              </span>
              <span class="hero-cs-visual__tag-text" data-hero-cs-tag>{{ $scene['tag'] }}</span>
            </span>
          </a>
        </div>
      </div>

      <div class="hero-cs-visual__cursor" data-hero-cs-cursor aria-hidden="true">
        <svg viewBox="0 0 24 28" width="28" height="32" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="heroCsCursorFill" x1="3" y1="2" x2="20" y2="26" gradientUnits="userSpaceOnUse">
              <stop stop-color="#2F69FB"/>
              <stop offset="1" stop-color="#C56BFF"/>
            </linearGradient>
          </defs>
          <path
            d="M4.2 2.2 19.5 12.4c.7.45.35 1.55-.5 1.55h-6.1l3.25 8.2c.25.65-.15 1.35-.85 1.5l-2.35.5c-.7.15-1.4-.3-1.55-.95L8.2 15.3 4.55 19.6c-.55.6-1.55.2-1.55-.6V3.35c0-.85.95-1.35 1.2-1.15Z"
            fill="url(#heroCsCursorFill)"
            stroke="#00003f"
            stroke-width="1.35"
            stroke-linejoin="round"/>
          <path
            d="M6.4 4.8 14.8 10.4"
            stroke="#ffffff"
            stroke-opacity=".5"
            stroke-width="1.35"
            stroke-linecap="round"/>
        </svg>
      </div>
    </div>
  </div>

  @once
  @push('scripts')
  <script>
    (function () {
      var HOLD_MS = 2800;
      var MOVE_MS = 850;
      var PRESS_MS = 220;
      var DRAG_MS = 520;
      var EXIT_MS = 620;
      var ENTER_MS = 720;

      function prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      }

      function parseScenes(root) {
        try {
          var node = root.querySelector('[data-hero-cs-scenes-json]');
          var raw = node ? node.textContent : '[]';
          var data = JSON.parse(raw || '[]');
          return Array.isArray(data) ? data : [];
        } catch (e) {
          return [];
        }
      }

      function preloadScene(scene) {
        if (!scene) return;
        [scene.brand_image, scene.photo_image, scene.chart_image].forEach(function (src) {
          if (!src) return;
          var img = new Image();
          img.src = src;
        });
      }

      function setImg(el, src, alt) {
        if (!el || !src) return;
        el.src = src;
        if (alt) {
          el.alt = alt;
          el.title = alt;
        }
      }

      function applyScene(root, scene) {
        if (!scene) return;
        var url = scene.url || '#';
        var alt = scene.alt || scene.title || '';
        var primary = scene.primary || {};
        var secondary = scene.secondary || {};
        var bars = Array.isArray(scene.bars) ? scene.bars : [42, 68, 92, 58, 76];
        var hasChartImage = !!scene.chart_image;

        root.querySelectorAll('[data-hero-cs-link]').forEach(function (link) {
          link.setAttribute('href', url);
        });

        var primaryValue = root.querySelector('[data-hero-cs-primary-value]');
        var primaryLabel = root.querySelector('[data-hero-cs-primary-label]');
        var secondaryValue = root.querySelector('[data-hero-cs-secondary-value]');
        var secondaryLabel = root.querySelector('[data-hero-cs-secondary-label]');
        var tag = root.querySelector('[data-hero-cs-tag]');
        var metricTile = root.querySelector('[data-hero-cs-tile="0"]');
        var photoTile = root.querySelector('[data-hero-cs-tile="1"]');
        var chartTile = root.querySelector('[data-hero-cs-chart-tile]');
        var secondaryTile = root.querySelector('[data-hero-cs-tile="3"]');
        var tagTile = root.querySelector('[data-hero-cs-tile="4"]');

        if (primaryValue) primaryValue.textContent = primary.value || '';
        if (primaryLabel) primaryLabel.textContent = primary.label_short || '';
        if (secondaryValue) secondaryValue.textContent = secondary.value || '';
        if (secondaryLabel) secondaryLabel.textContent = secondary.label_short || '';
        if (tag) tag.textContent = scene.tag || '';

        if (metricTile) {
          metricTile.setAttribute('aria-label', (scene.title || '') + ': ' + (primary.value || '') + ' ' + (primary.label_short || ''));
        }
        if (photoTile) photoTile.setAttribute('aria-label', scene.title || '');
        if (chartTile) {
          chartTile.setAttribute('aria-label', (scene.title || '') + ' results chart');
          chartTile.classList.toggle('has-chart-image', hasChartImage);
        }
        if (secondaryTile) {
          secondaryTile.setAttribute('aria-label', (scene.title || '') + ': ' + (secondary.value || '') + ' ' + (secondary.label_short || ''));
        }
        if (tagTile) tagTile.setAttribute('aria-label', scene.tag || '');

        setImg(root.querySelector('[data-hero-cs-brand]'), scene.brand_image, alt);
        setImg(root.querySelector('[data-hero-cs-photo]'), scene.photo_image, alt);

        var chartImg = root.querySelector('[data-hero-cs-chart-img]');
        if (chartImg) {
          if (hasChartImage) {
            setImg(chartImg, scene.chart_image, alt);
            chartImg.hidden = false;
          } else {
            chartImg.hidden = true;
          }
        }

        root.querySelectorAll('[data-hero-cs-bar]').forEach(function (bar, index) {
          var height = bars[index] != null ? bars[index] : 55;
          bar.style.setProperty('--hero-cs-bar', height + '%');
          bar.classList.toggle('is-active', index === 2);
        });
      }

      function tileCenter(stage, tile) {
        var stageBox = stage.getBoundingClientRect();
        var tileBox = tile.getBoundingClientRect();
        return {
          x: tileBox.left - stageBox.left + tileBox.width * 0.58,
          y: tileBox.top - stageBox.top + tileBox.height * 0.48
        };
      }

      function moveCursor(cursor, point, durationMs) {
        if (!cursor) return Promise.resolve();
        cursor.style.transitionDuration = (durationMs || MOVE_MS) + 'ms';
        cursor.style.setProperty('--hero-cs-cx', point.x + 'px');
        cursor.style.setProperty('--hero-cs-cy', point.y + 'px');
        return wait(durationMs || MOVE_MS);
      }

      function snapCursor(cursor, point) {
        if (!cursor) return;
        cursor.style.transition = 'none';
        cursor.style.setProperty('--hero-cs-cx', point.x + 'px');
        cursor.style.setProperty('--hero-cs-cy', point.y + 'px');
        cursor.offsetHeight;
        cursor.style.transition = '';
      }

      function wait(ms) {
        return new Promise(function (resolve) {
          window.setTimeout(resolve, ms);
        });
      }

      function activate(root) {
        var poster = root.querySelector('[data-hero-cs-poster]');
        var stage = root.querySelector('[data-hero-cs-stage]');
        var mosaic = root.querySelector('[data-hero-cs-mosaic]');
        var cursor = root.querySelector('[data-hero-cs-cursor]');
        var scenes = parseScenes(root);
        var index = 0;
        var tileIndex = 1;
        var pushUp = true;
        var running = false;
        var visible = true;
        var busy = false;

        if (!stage || !mosaic || scenes.length === 0) return;

        function showStage() {
          root.classList.add('is-ready', 'is-intro');
          stage.classList.remove('opacity-0');
          stage.classList.add('opacity-100', 'is-animated');
          if (poster) {
            poster.classList.add('is-hidden');
            window.setTimeout(function () {
              poster.setAttribute('hidden', '');
            }, 500);
          }
          window.setTimeout(function () {
            root.classList.remove('is-intro');
          }, 900);
        }

        if (prefersReducedMotion()) {
          showStage();
          if (cursor) cursor.setAttribute('hidden', '');
          applyScene(root, scenes[0]);
          return;
        }

        showStage();
        applyScene(root, scenes[0]);
        preloadScene(scenes[1] || scenes[0]);

        if (cursor) {
          var photoTile = root.querySelector('[data-hero-cs-tile="1"]');
          if (photoTile) snapCursor(cursor, tileCenter(stage, photoTile));
          cursor.classList.add('is-visible', 'is-idle');
        }

        function clearMotionClasses() {
          root.classList.remove(
            'is-pressing',
            'is-dragging',
            'is-exiting',
            'is-entering',
            'is-push-up',
            'is-push-down'
          );
          root.querySelectorAll('[data-hero-cs-tile]').forEach(function (tile) {
            tile.classList.remove('is-grabbed', 'is-cursor-target');
            tile.style.removeProperty('--hero-cs-drag-y');
          });
          if (cursor) {
            cursor.classList.remove('is-pressing', 'is-dragging', 'is-clicking');
            cursor.classList.add('is-idle');
          }
        }

        async function cycleOnce() {
          if (!running || busy || !visible || document.hidden || scenes.length < 2) return;
          busy = true;
          clearMotionClasses();

          var tiles = Array.prototype.slice.call(root.querySelectorAll('[data-hero-cs-tile]'));
          if (!tiles.length) {
            busy = false;
            return;
          }

          tileIndex = tileIndex % tiles.length;
          var target = tiles[tileIndex];
          tileIndex = (tileIndex + 2) % tiles.length;
          var directionUp = pushUp;
          pushUp = !pushUp;
          var exitClass = directionUp ? 'is-push-up' : 'is-push-down';
          var dragSign = directionUp ? -1 : 1;

          if (cursor) cursor.classList.remove('is-idle');

          var grabPoint = tileCenter(stage, target);
          await moveCursor(cursor, grabPoint, MOVE_MS);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          target.classList.add('is-cursor-target', 'is-grabbed');
          root.classList.add('is-pressing');
          if (cursor) cursor.classList.add('is-pressing');
          await wait(PRESS_MS);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          root.classList.remove('is-pressing');
          root.classList.add('is-dragging', exitClass);
          if (cursor) {
            cursor.classList.remove('is-pressing');
            cursor.classList.add('is-dragging');
          }

          var dragPoint = {
            x: grabPoint.x + (directionUp ? -6 : 6),
            y: grabPoint.y + dragSign * 54
          };
          target.style.setProperty('--hero-cs-drag-y', (dragSign * 28) + 'px');
          await moveCursor(cursor, dragPoint, DRAG_MS);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          root.classList.add('is-exiting');
          await wait(EXIT_MS * 0.55);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          index = (index + 1) % scenes.length;
          applyScene(root, scenes[index]);
          preloadScene(scenes[(index + 1) % scenes.length]);

          root.classList.remove('is-exiting', 'is-dragging');
          root.classList.add('is-entering');
          target.classList.remove('is-grabbed');
          target.style.removeProperty('--hero-cs-drag-y');

          var settlePoint = tileCenter(stage, target);
          await moveCursor(cursor, {
            x: settlePoint.x,
            y: settlePoint.y + dragSign * -18
          }, ENTER_MS * 0.45);

          await wait(ENTER_MS * 0.55);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          clearMotionClasses();
          if (cursor) {
            await moveCursor(cursor, tileCenter(stage, target), 420);
            cursor.classList.add('is-idle');
          }
          busy = false;
        }

        async function loop() {
          running = true;
          while (running) {
            await wait(HOLD_MS);
            if (!running) break;
            if (!visible || document.hidden || busy) {
              await wait(350);
              continue;
            }
            try {
              await cycleOnce();
            } catch (e) {
              clearMotionClasses();
              busy = false;
            }
          }
        }

        if ('IntersectionObserver' in window) {
          var observer = new IntersectionObserver(function (entries) {
            visible = entries.some(function (entry) { return entry.isIntersecting; });
          }, { threshold: 0.2 });
          observer.observe(root);
        }

        document.addEventListener('visibilitychange', function () {
          if (!document.hidden && visible && scenes.length > 1) {
            preloadScene(scenes[(index + 1) % scenes.length]);
          }
        });

        if (scenes.length > 1) {
          loop();
        }
      }

      function boot() {
        document.querySelectorAll('[data-hero-cs-visual]').forEach(activate);
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
@endif
