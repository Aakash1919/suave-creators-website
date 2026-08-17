<div class="site-preloader" data-site-preloader role="status" aria-label="{{ $label }}">
    <span class="site-preloader__spinner" aria-hidden="true"></span>
</div>
{{-- Must run inline at body start: the overlay is visible by default and lifts when document is ready (at least $minDisplayTime). --}}
<script> 
    (function () { 
        var root = document.documentElement; 
        var startTime = Date.now(); 
        var minDisplayTime = {{ $minDisplayTime }}; 
        var timeout = {{ $timeout }}; 
        var revealed = false; 
 
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
 
        function scheduleReveal() { 
            var elapsed = Date.now() - startTime; 
            var remaining = Math.max(0, minDisplayTime - elapsed); 
            window.setTimeout(executeReveal, remaining); 
        } 
 
        if (document.readyState === 'interactive' || document.readyState === 'complete') { 
            scheduleReveal(); 
        } else { 
            document.addEventListener('DOMContentLoaded', scheduleReveal); 
        } 
        
        window.addEventListener('load', scheduleReveal); 
        window.setTimeout(executeReveal, timeout); 
    })(); 
</script> 



