import { animate, stagger } from 'motion';

/** Exact GrowthNatives shared Framer enter variants. */
const GN_EASE = [0.22, 1, 0.36, 1];
const GN_DURATION = 0.75;
const GN_STAGGER = 0.12;
const GN_Y = 28;
const GN_BLUR = '10px';

/** Framer drag defaults (dragElastic .35, bounce spring 200/40). */
const DRAG_LIMIT = 56;
const DRAG_ELASTIC = 0.35;
const DRAG_SPRING = { type: 'spring', stiffness: 200, damping: 40, mass: 0.8 };
const TILT_SPRING = { type: 'spring', stiffness: 150, damping: 18 };

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function settle(root) {
    root.querySelectorAll('[data-bento-card]').forEach((card) => {
        card.style.opacity = '1';
        card.style.filter = 'none';
        card.style.transform = 'none';
    });
    root.querySelectorAll('.bento__bar').forEach((bar) => {
        bar.style.transform = 'scaleY(1)';
    });
}

function playBars(root) {
    const bars = root.querySelectorAll('.bento__bar');
    if (!bars.length) {
        return;
    }

    animate(
        bars,
        { scaleY: [0, 1] },
        {
            delay: stagger(0.06, { startDelay: 0.04 }),
            duration: 0.55,
            easing: GN_EASE,
        },
    );
}

function elasticOffset(delta, limit, elastic = DRAG_ELASTIC) {
    const abs = Math.abs(delta);
    if (abs <= limit) {
        return delta;
    }

    const overflow = abs - limit;
    const softened = limit + overflow * elastic;
    return delta < 0 ? -softened : softened;
}

function bindDrag(card, root) {
    let pointerId = null;
    let startX = 0;
    let startY = 0;
    let lastX = 0;
    let lastY = 0;
    let prevX = 0;
    let prevY = 0;
    let lastT = 0;
    let velocityX = 0;
    let velocityY = 0;
    let dragged = false;
    let releaseAnimation = null;

    const paint = (x, y, scale = 1) => {
        card.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${scale})`;
    };

    const onPointerDown = (event) => {
        if (event.button !== 0 && event.pointerType === 'mouse') {
            return;
        }

        if (releaseAnimation) {
            releaseAnimation.stop();
            releaseAnimation = null;
        }

        pointerId = event.pointerId;
        dragged = false;
        startX = event.clientX - lastX;
        startY = event.clientY - lastY;
        prevX = lastX;
        prevY = lastY;
        velocityX = 0;
        velocityY = 0;
        lastT = performance.now();
        card.classList.add('is-dragging', 'is-paused');
        card.setPointerCapture(pointerId);
        root.querySelectorAll('[data-bento-card]').forEach((other) => {
            other.style.zIndex = other === card ? '8' : '1';
        });
    };

    const onPointerMove = (event) => {
        if (pointerId !== event.pointerId) {
            return;
        }

        const nextX = elasticOffset(event.clientX - startX, DRAG_LIMIT);
        const nextY = elasticOffset(event.clientY - startY, DRAG_LIMIT);

        if (Math.hypot(nextX - prevX, nextY - prevY) > 1) {
            dragged = true;
        }

        const now = performance.now();
        const dt = Math.max(now - lastT, 16);
        velocityX = ((nextX - lastX) / dt) * 1000;
        velocityY = ((nextY - lastY) / dt) * 1000;
        lastX = nextX;
        lastY = nextY;
        lastT = now;
        paint(nextX, nextY, 1.03);
    };

    const finishDrag = (event) => {
        if (pointerId !== event.pointerId) {
            return;
        }

        pointerId = null;
        card.classList.remove('is-dragging');

        const coastX = elasticOffset(lastX + velocityX * 0.06, DRAG_LIMIT);
        const coastY = elasticOffset(lastY + velocityY * 0.06, DRAG_LIMIT);

        // Hand control to Motion for inertia-ish spring home.
        card.style.transform = '';
        releaseAnimation = animate(
            card,
            {
                x: [lastX, coastX, 0],
                y: [lastY, coastY, 0],
                scale: [1.03, 1.02, 1],
            },
            DRAG_SPRING,
        );

        releaseAnimation.finished.then(() => {
            lastX = 0;
            lastY = 0;
            releaseAnimation = null;
            card.style.transform = '';
            card.style.x = '';
            card.style.y = '';
            card.classList.remove('is-paused');
            card.style.zIndex = '';
        });
    };

    const onClickCapture = (event) => {
        if (!dragged) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();
        dragged = false;
    };

    card.addEventListener('pointerdown', onPointerDown);
    card.addEventListener('pointermove', onPointerMove);
    card.addEventListener('pointerup', finishDrag);
    card.addEventListener('pointercancel', finishDrag);
    card.addEventListener('click', onClickCapture, true);
}

function bindTilt(card) {
    const onMove = (event) => {
        if (card.classList.contains('is-dragging') || card.classList.contains('is-paused')) {
            return;
        }

        const rect = card.getBoundingClientRect();
        const nx = (event.clientX - rect.left - rect.width / 2) / Math.max(rect.width / 2, 1);
        const ny = (event.clientY - rect.top - rect.height / 2) / Math.max(rect.height / 2, 1);

        animate(
            card,
            {
                rotateX: Math.max(-5, Math.min(5, -ny * 5)),
                rotateY: Math.max(-5, Math.min(5, nx * 5)),
            },
            TILT_SPRING,
        );
    };

    const onLeave = () => {
        if (card.classList.contains('is-dragging')) {
            return;
        }

        animate(card, { rotateX: 0, rotateY: 0 }, TILT_SPRING);
    };

    card.addEventListener('pointermove', onMove);
    card.addEventListener('pointerleave', onLeave);
}

function reveal(root) {
    if (root.getAttribute('data-bento-played') === '1') {
        return;
    }

    root.setAttribute('data-bento-played', '1');
    root.classList.add('is-visible');

    const cards = [...root.querySelectorAll('[data-bento-card]')];

    if (prefersReducedMotion()) {
        settle(root);
        return;
    }

    animate(
        cards,
        {
            opacity: [0, 1],
            y: [GN_Y, 0],
            filter: [`blur(${GN_BLUR})`, 'blur(0px)'],
        },
        {
            delay: stagger(GN_STAGGER),
            duration: GN_DURATION,
            easing: GN_EASE,
        },
    ).finished.then(() => {
        if (!root.isConnected) {
            return;
        }

        playBars(root);
        cards.forEach((card) => {
            // Clear entrance transforms so drag/tilt own the element.
            card.style.transform = '';
            card.style.filter = 'none';
            card.style.opacity = '1';
            bindDrag(card, root);
            bindTilt(card);
        });
    });
}

function watch(root) {
    if (prefersReducedMotion()) {
        reveal(root);
        return;
    }

    if (!('IntersectionObserver' in window)) {
        reveal(root);
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                reveal(entry.target);
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.25 },
    );

    observer.observe(root);
}

function boot() {
    document.querySelectorAll('[data-bento]').forEach(watch);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
