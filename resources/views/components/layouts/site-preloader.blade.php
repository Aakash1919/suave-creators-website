<div class="site-preloader" data-site-preloader role="status" aria-label="{{ $label }}">
    <span class="site-preloader__spinner" aria-hidden="true"></span>
</div>
{{-- Must run inline at body start: the overlay has to lift the moment the deferred sheets apply, before any deferred JS. --}}
<script> 
    (function () { 
        var root = document.documentElement; 
        var timeout = {{ $timeout }}; 
        var revealed = false; 
 
        root.classList.add('is-css-pending'); 
 
        function reveal() { 
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
 
        function stylesPending() { 
            var links = document.querySelectorAll('link[data-suave-css]'); 
 
            for (var i = 0; i < links.length; i++) { 
                // media stays "print" until the link's own onload swaps it to "all". 
                if (!links[i].sheet || links[i].media === 'print') return true; 
            } 
 
            return false; 
        } 
 
        function poll() { 
            if (stylesPending()) { 
                window.setTimeout(poll, 50); 
                return; 
            } 
 
            reveal(); 
        } 
 
        poll(); 
        
        window.setTimeout(reveal, timeout); 
        window.addEventListener('load', reveal);
    })(); 
</script> 



