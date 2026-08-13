/**
 * Defers third-party JS (GTM / gtag / Swiper) and non-critical font CSS until after LCP.
 * Page scripts should init carousels via window.suaveWhenSwiperReady(fn).
 * Compatible with a tiny head/body stub that queues calls before this file runs (defer).
 */
(function () {
  'use strict';

  var cfg = window.__suavePerf || {};
  var analyticsLoaded = false;
  var swiperLoading = null;
  var swiperCallbacks = Array.isArray(window.__suaveSwiperQ) ? window.__suaveSwiperQ.slice() : [];
  var swiperScheduled = false;
  window.__suaveSwiperQ = swiperCallbacks;

  function loadScript(src, options) {
    return new Promise(function (resolve, reject) {
      var s = document.createElement('script');
      s.src = src;
      if (options && options.async) {
        s.async = true;
      }
      s.onload = function () { resolve(); };
      s.onerror = function () { reject(new Error('Failed to load ' + src)); };
      document.head.appendChild(s);
    });
  }

  function ensureStylesheet(href, marker) {
    if (!href || document.querySelector('link[' + marker + ']')) return;
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = href;
    link.setAttribute(marker, '1');
    document.head.appendChild(link);
  }

  function loadFaWebfonts() {
    ensureStylesheet(cfg.faExtraCss, 'data-suave-fa-extra');
  }

  function loadPpMori() {
    ensureStylesheet(cfg.ppMoriCss, 'data-suave-pp-mori');
  }

  function scheduleDeferredFonts() {
    function idleInject(fn, timeoutMs) {
      if ('requestIdleCallback' in window) {
        requestIdleCallback(fn, { timeout: timeoutMs });
      } else {
        setTimeout(fn, Math.min(timeoutMs, 1500));
      }
    }

    function afterLoad(fn) {
      if (document.readyState === 'complete') {
        fn();
      } else {
        window.addEventListener('load', fn, { once: true });
      }
    }

    // Solid FA is already declared in critical CSS + preloaded; delay extra faces
    // so stylesheet injection does not compete with LCP style/layout work.
    afterLoad(function () {
      idleInject(loadFaWebfonts, 2500);
      idleInject(loadPpMori, 4000);
    });
  }

  function loadAnalytics() {
    if (analyticsLoaded) return;
    analyticsLoaded = true;

    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function () { window.dataLayer.push(arguments); };

    var gaId = cfg.gaId;
    var gtmId = cfg.gtmId;

    if (gaId) {
      loadScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(gaId), {
        async: true
      }).catch(function () {});
    }

    if (gtmId) {
      (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
        var f = d.getElementsByTagName(s)[0];
        var j = d.createElement(s);
        var dl = l !== 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', gtmId);
    }
  }

  function scheduleAnalytics() {
    if (!cfg.gaId && !cfg.gtmId) return;

    var events = ['scroll', 'click', 'touchstart', 'keydown', 'pointerdown'];
    events.forEach(function (name) {
      window.addEventListener(name, loadAnalytics, { once: true, passive: true });
    });

    function idleLoad() {
      if ('requestIdleCallback' in window) {
        requestIdleCallback(function () { loadAnalytics(); }, { timeout: 3500 });
      } else {
        setTimeout(loadAnalytics, 2500);
      }
    }

    if (document.readyState === 'complete') {
      idleLoad();
    } else {
      window.addEventListener('load', idleLoad, { once: true });
    }
  }

  function flushSwiperCallbacks() {
    var cbs = swiperCallbacks.slice();
    swiperCallbacks.length = 0;
    cbs.forEach(function (fn) {
      try {
        fn();
      } catch (err) {
        if (typeof console !== 'undefined' && console.error) {
          console.error(err);
        }
      }
    });
  }

  function loadSwiper() {
    if (typeof window.Swiper !== 'undefined') {
      flushSwiperCallbacks();
      return Promise.resolve();
    }
    if (swiperLoading) return swiperLoading;

    if (cfg.swiperCss) {
      ensureStylesheet(cfg.swiperCss, 'data-suave-swiper-css');
    }

    swiperLoading = loadScript(cfg.swiperJs || 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js')
      .then(function () {
        document.dispatchEvent(new CustomEvent('suave:swiper-ready'));
        flushSwiperCallbacks();
      })
      .catch(function () {
        swiperLoading = null;
      });

    return swiperLoading;
  }

  function scheduleSwiperLoad() {
    if (swiperScheduled) return;
    if (!document.querySelector('.swiper')) return;
    swiperScheduled = true;

    var loadSoon = function () {
      loadSwiper();
    };

    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        if (entries.some(function (entry) { return entry.isIntersecting; })) {
          io.disconnect();
          loadSoon();
        }
      }, { rootMargin: '200px 0px', threshold: 0.01 });

      document.querySelectorAll('.swiper').forEach(function (el) {
        io.observe(el);
      });

      window.addEventListener('load', function () {
        setTimeout(loadSoon, 8000);
      }, { once: true });
    } else {
      loadSoon();
    }
  }

  window.suaveWhenSwiperReady = function (fn) {
    if (typeof fn !== 'function') return;

    if (typeof window.Swiper !== 'undefined') {
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn);
      } else {
        fn();
      }
      return;
    }

    swiperCallbacks.push(fn);
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', scheduleSwiperLoad);
    } else {
      scheduleSwiperLoad();
    }
  };

  scheduleDeferredFonts();
  scheduleAnalytics();

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', scheduleSwiperLoad);
  } else {
    scheduleSwiperLoad();
  }
})();
