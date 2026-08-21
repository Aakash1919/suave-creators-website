@if ($scene)
  @php
    $caseHref = ($scene['url'] ?? '') !== '' ? (string) $scene['url'] : route('case-studies');
    $hasChartImage = ! empty($scene['chart_image']);
    $bars = is_array($scene['bars'] ?? null) ? $scene['bars'] : [42, 68, 92, 58, 76];
  @endphp
  <div
    class="hero-cs-visual{{ $wrapperClass !== '' ? ' '.$wrapperClass : '' }}"
    data-hero-cs-visual
    @unless ($animate) data-hero-cs-static @endunless>
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
        <span class="hero-cs-visual__cursor-hand">
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
        </span>
      </div>
    </div>
  </div>

  @once
  @push('scripts')
  <script>
    (function () {
      // Smooth cycle — longer hold + eased motion (about 3s hold + 3.4s motion)
      var HOLD_MS = 3000;
      var MOVE_MS = 920;
      var PRESS_MS = 180;
      var DRAG_MS = 620;
      var EXIT_MS = 820;
      var ENTER_MS = 980;
      var SETTLE_MS = 480;
      var CURSOR_EASE = 'cubic-bezier(0.22, 0.61, 0.36, 1)';

      var PATTERNS = [
        {
          id: 'lift',
          grab: 'up',
          offsets: [
            { x: -8, y: -70, r: -3, s: 0.94 },
            { x: 10, y: -78, r: 2, s: 0.92 },
            { x: -12, y: -64, r: -2, s: 0.95 },
            { x: 6, y: -72, r: 3, s: 0.93 },
            { x: -4, y: -60, r: -1, s: 0.96 }
          ]
        },
        {
          id: 'drop',
          grab: 'down',
          offsets: [
            { x: 6, y: 70, r: 2, s: 0.94 },
            { x: -8, y: 78, r: -3, s: 0.92 },
            { x: 10, y: 64, r: 2, s: 0.95 },
            { x: -6, y: 72, r: -2, s: 0.93 },
            { x: 4, y: 60, r: 1, s: 0.96 }
          ]
        },
        {
          id: 'cascade',
          grab: 'side',
          offsets: [
            { x: -90, y: -8, r: -6, s: 0.94 },
            { x: 90, y: -6, r: 6, s: 0.93 },
            { x: -85, y: 10, r: -5, s: 0.95 },
            { x: 88, y: 8, r: 5, s: 0.94 },
            { x: -70, y: 12, r: -4, s: 0.96 }
          ]
        },
        {
          id: 'fan',
          grab: 'center',
          offsets: [
            { x: -55, y: -45, r: -12, s: 0.86 },
            { x: 58, y: -42, r: 12, s: 0.86 },
            { x: -52, y: 48, r: -10, s: 0.88 },
            { x: 50, y: 38, r: 10, s: 0.88 },
            { x: 8, y: 62, r: 4, s: 0.9 }
          ]
        },
        {
          id: 'flip',
          grab: 'photo',
          offsets: [
            { x: 0, y: 0, r: 0, s: 1 },
            { x: 0, y: 0, r: 0, s: 1 },
            { x: 0, y: 0, r: 0, s: 1 },
            { x: 0, y: 0, r: 0, s: 1 },
            { x: 0, y: 0, r: 0, s: 1 }
          ]
        },
        {
          id: 'wave',
          grab: 'up',
          offsets: [
            { x: -6, y: -55, r: -2, s: 0.95 },
            { x: 6, y: 55, r: 2, s: 0.95 },
            { x: -8, y: -48, r: -3, s: 0.94 },
            { x: 8, y: 52, r: 3, s: 0.94 },
            { x: -4, y: -42, r: -1, s: 0.96 }
          ]
        },
        {
          id: 'zoom',
          grab: 'photo',
          offsets: [
            { x: -20, y: -10, r: -4, s: 0.72 },
            { x: 0, y: 0, r: 0, s: 1.18 },
            { x: 18, y: 12, r: 4, s: 0.7 },
            { x: -14, y: 16, r: -3, s: 0.74 },
            { x: 16, y: 20, r: 3, s: 0.76 }
          ]
        }
      ];

      var PATTERN_CLASSES = PATTERNS.map(function (p) { return 'is-pattern-' + p.id; });

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
          img.decoding = 'async';
          img.src = src;
        });
      }

      function setImg(el, src, alt) {
        if (!el || !src || el.getAttribute('src') === src) {
          if (el && alt) {
            el.alt = alt;
            el.title = alt;
          }
          return;
        }
        el.src = src;
        if (alt) {
          el.alt = alt;
          el.title = alt;
        }
      }

      function wait(ms) {
        return new Promise(function (resolve) {
          window.setTimeout(resolve, ms);
        });
      }

      function activate(root) {
        if (!root || root.dataset.heroCsBound === '1') return;
        root.dataset.heroCsBound = '1';

        var poster = root.querySelector('[data-hero-cs-poster]');
        var stage = root.querySelector('[data-hero-cs-stage]');
        var mosaic = root.querySelector('[data-hero-cs-mosaic]');
        var cursor = root.querySelector('[data-hero-cs-cursor]');
        var scenes = parseScenes(root);
        var index = 0;
        var tileIndex = 1;
        var patternIndex = 0;
        var running = false;
        var visible = true;
        var busy = false;
        var allowAnimate = !root.hasAttribute('data-hero-cs-static');

        if (!stage || !mosaic || scenes.length === 0) return;

        var refs = {
          links: root.querySelectorAll('[data-hero-cs-link]'),
          tiles: root.querySelectorAll('[data-hero-cs-tile]'),
          primaryValue: root.querySelector('[data-hero-cs-primary-value]'),
          primaryLabel: root.querySelector('[data-hero-cs-primary-label]'),
          secondaryValue: root.querySelector('[data-hero-cs-secondary-value]'),
          secondaryLabel: root.querySelector('[data-hero-cs-secondary-label]'),
          tag: root.querySelector('[data-hero-cs-tag]'),
          metricTile: root.querySelector('[data-hero-cs-tile="0"]'),
          photoTile: root.querySelector('[data-hero-cs-tile="1"]'),
          chartTile: root.querySelector('[data-hero-cs-chart-tile]'),
          secondaryTile: root.querySelector('[data-hero-cs-tile="3"]'),
          tagTile: root.querySelector('[data-hero-cs-tile="4"]'),
          brand: root.querySelector('[data-hero-cs-brand]'),
          photo: root.querySelector('[data-hero-cs-photo]'),
          chartImg: root.querySelector('[data-hero-cs-chart-img]'),
          bars: root.querySelectorAll('[data-hero-cs-bar]')
        };

        var tileCenters = [];

        function measureCenters() {
          var stageBox = stage.getBoundingClientRect();
          tileCenters = Array.prototype.map.call(refs.tiles, function (tile) {
            var box = tile.getBoundingClientRect();
            return {
              x: box.left - stageBox.left + box.width * 0.58,
              y: box.top - stageBox.top + box.height * 0.48
            };
          });
        }

        function applyScene(scene) {
          if (!scene) return;
          var url = scene.url || '#';
          var alt = scene.alt || scene.title || '';
          var primary = scene.primary || {};
          var secondary = scene.secondary || {};
          var bars = Array.isArray(scene.bars) ? scene.bars : [42, 68, 92, 58, 76];
          var hasChartImage = !!scene.chart_image;

          refs.links.forEach(function (link) {
            link.setAttribute('href', url);
          });

          if (refs.primaryValue) refs.primaryValue.textContent = primary.value || '';
          if (refs.primaryLabel) refs.primaryLabel.textContent = primary.label_short || '';
          if (refs.secondaryValue) refs.secondaryValue.textContent = secondary.value || '';
          if (refs.secondaryLabel) refs.secondaryLabel.textContent = secondary.label_short || '';
          if (refs.tag) refs.tag.textContent = scene.tag || '';

          if (refs.metricTile) {
            refs.metricTile.setAttribute('aria-label', (scene.title || '') + ': ' + (primary.value || '') + ' ' + (primary.label_short || ''));
          }
          if (refs.photoTile) refs.photoTile.setAttribute('aria-label', scene.title || '');
          if (refs.chartTile) {
            refs.chartTile.setAttribute('aria-label', (scene.title || '') + ' results chart');
            refs.chartTile.classList.toggle('has-chart-image', hasChartImage);
          }
          if (refs.secondaryTile) {
            refs.secondaryTile.setAttribute('aria-label', (scene.title || '') + ': ' + (secondary.value || '') + ' ' + (secondary.label_short || ''));
          }
          if (refs.tagTile) refs.tagTile.setAttribute('aria-label', scene.tag || '');

          setImg(refs.brand, scene.brand_image, alt);
          setImg(refs.photo, scene.photo_image, alt);

          if (refs.chartImg) {
            if (hasChartImage) {
              setImg(refs.chartImg, scene.chart_image, alt);
              refs.chartImg.hidden = false;
            } else {
              refs.chartImg.hidden = true;
            }
          }

          refs.bars.forEach(function (bar, i) {
            bar.style.setProperty('--hero-cs-bar', (bars[i] != null ? bars[i] : 55) + '%');
            bar.classList.toggle('is-active', i === 2);
          });
        }

        function moveCursor(point, durationMs) {
          if (!cursor) return Promise.resolve();
          var ms = durationMs || MOVE_MS;
          cursor.classList.remove('is-idle');
          cursor.style.transitionProperty = 'transform, opacity';
          cursor.style.transitionDuration = ms + 'ms';
          cursor.style.transitionTimingFunction = CURSOR_EASE;
          cursor.style.setProperty('--hero-cs-cx', point.x + 'px');
          cursor.style.setProperty('--hero-cs-cy', point.y + 'px');
          return wait(ms);
        }

        function snapCursor(point) {
          if (!cursor) return;
          cursor.style.transition = 'none';
          cursor.style.setProperty('--hero-cs-cx', point.x + 'px');
          cursor.style.setProperty('--hero-cs-cy', point.y + 'px');
          cursor.offsetHeight;
          cursor.style.transition = '';
          cursor.style.transitionProperty = '';
          cursor.style.transitionDuration = '';
          cursor.style.transitionTimingFunction = '';
        }

        function showStage() {
          root.classList.add('is-ready', 'is-intro');
          stage.classList.remove('opacity-0');
          stage.classList.add('opacity-100', 'is-animated');
          if (poster) {
            poster.classList.add('is-hidden');
            window.setTimeout(function () {
              poster.setAttribute('hidden', '');
            }, 320);
          }
          window.setTimeout(function () {
            root.classList.remove('is-intro');
            measureCenters();
          }, 520);
        }

        if (prefersReducedMotion() || !allowAnimate) {
          showStage();
          if (cursor) cursor.setAttribute('hidden', '');
          applyScene(scenes[0]);
          return;
        }

        showStage();
        applyScene(scenes[0]);
        scenes.forEach(preloadScene);
        measureCenters();

        if (cursor) {
          if (tileCenters[1]) snapCursor(tileCenters[1]);
          else if (refs.photoTile) {
            var stageBox = stage.getBoundingClientRect();
            var box = refs.photoTile.getBoundingClientRect();
            snapCursor({
              x: box.left - stageBox.left + box.width * 0.58,
              y: box.top - stageBox.top + box.height * 0.48
            });
          }
          cursor.classList.add('is-visible', 'is-idle');
        }

        function clearMotionClasses() {
          root.classList.remove.apply(root.classList, [
            'is-pressing',
            'is-dragging',
            'is-exiting',
            'is-entering'
          ].concat(PATTERN_CLASSES));
          refs.tiles.forEach(function (tile) {
            tile.classList.remove('is-grabbed', 'is-cursor-target');
            tile.style.removeProperty('--hero-cs-ox');
            tile.style.removeProperty('--hero-cs-oy');
            tile.style.removeProperty('--hero-cs-rot');
            tile.style.removeProperty('--hero-cs-scale');
            tile.style.removeProperty('--hero-cs-delay');
            tile.style.removeProperty('--hero-cs-drag-y');
          });
          if (cursor) {
            cursor.classList.remove('is-pressing', 'is-dragging', 'is-clicking');
            cursor.classList.add('is-idle');
          }
        }

        function applyPatternOffsets(pattern, reverse) {
          refs.tiles.forEach(function (tile, i) {
            var offset = pattern.offsets[i] || pattern.offsets[0];
            var mul = reverse ? -1 : 1;
            tile.style.setProperty('--hero-cs-ox', (offset.x * mul) + '%');
            tile.style.setProperty('--hero-cs-oy', (offset.y * mul) + '%');
            tile.style.setProperty('--hero-cs-rot', (offset.r * mul) + 'deg');
            tile.style.setProperty('--hero-cs-scale', String(offset.s));
            tile.style.setProperty('--hero-cs-delay', (i * 0.07) + 's');
          });
        }

        function grabPointFor(pattern, fallbackIndex) {
          var prefer = fallbackIndex;
          if (pattern.grab === 'photo') prefer = 1;
          else if (pattern.grab === 'center') prefer = 1;
          else if (pattern.grab === 'side') prefer = patternIndex % 2 === 0 ? 0 : 1;
          else if (pattern.grab === 'down') prefer = 2;
          prefer = prefer % refs.tiles.length;
          return {
            index: prefer,
            point: tileCenters[prefer] || { x: 180, y: 180 }
          };
        }

        function dragDelta(pattern) {
          if (pattern.grab === 'up') return { x: -4, y: -34 };
          if (pattern.grab === 'down') return { x: 4, y: 34 };
          if (pattern.grab === 'side') return { x: patternIndex % 2 === 0 ? -42 : 42, y: -6 };
          if (pattern.grab === 'center' || pattern.grab === 'photo') return { x: 0, y: -22 };
          return { x: 0, y: -28 };
        }

        async function cycleOnce() {
          if (!running || busy || !visible || document.hidden || scenes.length < 2) return;
          busy = true;
          clearMotionClasses();

          if (!tileCenters.length) measureCenters();
          if (!refs.tiles.length) {
            busy = false;
            return;
          }

          var pattern = PATTERNS[patternIndex % PATTERNS.length];
          patternIndex += 1;
          var patternClass = 'is-pattern-' + pattern.id;
          var grab = grabPointFor(pattern, tileIndex);
          tileIndex = (grab.index + 2) % refs.tiles.length;
          var target = refs.tiles[grab.index];
          var grabPoint = grab.point;
          var delta = dragDelta(pattern);

          applyPatternOffsets(pattern, false);
          root.classList.add(patternClass);
          if (cursor) cursor.classList.remove('is-idle');

          await moveCursor(grabPoint, MOVE_MS);
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
          root.classList.add('is-dragging');
          if (cursor) {
            cursor.classList.remove('is-pressing');
            cursor.classList.add('is-dragging');
          }

          target.style.setProperty('--hero-cs-drag-y', delta.y + 'px');
          await moveCursor({
            x: grabPoint.x + delta.x,
            y: grabPoint.y + delta.y
          }, DRAG_MS);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          // Drop drag state before exit so CSS animation:none cannot zero exit duration
          root.classList.remove('is-dragging', 'is-pressing');
          if (cursor) cursor.classList.remove('is-dragging', 'is-pressing');
          target.style.removeProperty('--hero-cs-drag-y');

          root.classList.add('is-exiting');
          await wait(EXIT_MS * 0.52);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          index = (index + 1) % scenes.length;
          applyScene(scenes[index]);
          // Keep the same per-tile vectors so enter travels back from the exit destinations
          applyPatternOffsets(pattern, false);

          root.classList.remove('is-exiting');
          root.classList.add('is-entering');
          target.classList.remove('is-grabbed');

          moveCursor({
            x: grabPoint.x - delta.x * 0.35,
            y: grabPoint.y - delta.y * 0.35
          }, ENTER_MS * 0.55);

          await wait(ENTER_MS);
          if (!running || !visible || document.hidden) {
            clearMotionClasses();
            busy = false;
            return;
          }

          clearMotionClasses();
          if (cursor) {
            await moveCursor(grabPoint, SETTLE_MS);
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
              await wait(200);
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
          }, { threshold: 0.15 });
          observer.observe(root);
        }

        var resizeTimer = null;
        window.addEventListener('resize', function () {
          window.clearTimeout(resizeTimer);
          resizeTimer = window.setTimeout(measureCenters, 120);
        }, { passive: true });

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
