<div class="site-preloader" data-site-preloader role="status" aria-label="{{ $label }}">
    <svg class="site-preloader__spinner" viewBox="0 0 100 100" aria-hidden="true" focusable="false">
        <defs>
            <rect id="site-preloader-pill" x="38" y="8" width="24" height="15" rx="7.5" stroke="#0b2a73" stroke-width="4" />
        </defs>
        <use href="#site-preloader-pill" fill="#6b66ff" />
        <use href="#site-preloader-pill" fill="#6b66ff" transform="rotate(-45 50 50)" />
        <use href="#site-preloader-pill" fill="#9ab8f7" transform="rotate(-90 50 50)" />
        <use href="#site-preloader-pill" fill="#9ab8f7" transform="rotate(-135 50 50)" />
        <use href="#site-preloader-pill" fill="#d5deff" transform="rotate(180 50 50)" />
        <use href="#site-preloader-pill" fill="#d5deff" transform="rotate(135 50 50)" />
        <use href="#site-preloader-pill" fill="#fff" transform="rotate(90 50 50)" />
        <use href="#site-preloader-pill" fill="#fff" transform="rotate(45 50 50)" />
    </svg>
</div>
{{-- Must run inline at body start: the overlay lifts once the data-suave-css sheets apply (at least $minDisplayTime), never waiting on deferred/CDN scripts. --}}
<script>
    (function () {
        var root = document.documentElement;
        var startTime = Date.now();
        var minDisplayTime = {{ $minDisplayTime }};
        var timeout = {{ $timeout }};
        var revealed = false;
        var failedSheets = [];

        root.classList.add('is-css-pending');

        function executeReveal() {
            if (revealed) return;
            revealed = true;

            root.classList.remove('is-css-pending');
            root.classList.add('is-css-ready');

            var overlay = document.querySelector('[data-site-preloader]');
            if (!overlay) return;

            window.setTimeout(function () {
                if (overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }, 400);
        }

        function sheetsReady() {
            var links = document.querySelectorAll('link[data-suave-css]');
            for (var i = 0; i < links.length; i++) {
                if (links[i].media === 'print' && failedSheets.indexOf(links[i]) === -1) {
                    return false;
                }
            }
            return true;
        }

        function checkReveal() {
            if (revealed || !sheetsReady()) return;
            window.setTimeout(executeReveal, Math.max(0, minDisplayTime - (Date.now() - startTime)));
        }

        // Capture runs before each link's inline onload flips media, so re-check on the next tick.
        document.addEventListener('load', function (event) {
            if (event.target.tagName === 'LINK') window.setTimeout(checkReveal, 0);
        }, true);
        document.addEventListener('error', function (event) {
            if (event.target.tagName === 'LINK') {
                failedSheets.push(event.target);
                checkReveal();
            }
        }, true);

        checkReveal();
        window.addEventListener('load', executeReveal);
        window.setTimeout(executeReveal, timeout);
    })();
</script>
