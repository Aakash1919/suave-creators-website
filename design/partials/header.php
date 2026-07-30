<?php
$dropdowns = [
    'Services' => [
        ['href' => '/service/web-development-services', 'label' => 'Web Development Service', 'icon' => 'fa-solid fa-laptop-code'],
        ['href' => '/service/custom-crm-development', 'label' => 'CRM Development Service', 'icon' => 'fa-solid fa-users'],
        ['href' => '/service/enterprise-software-solutions', 'label' => 'Enterprise Software Solutions', 'icon' => 'fa-solid fa-building'],
        ['href' => '/service/e-commerce-development', 'label' => 'E-commerce Development Service', 'icon' => 'fa-solid fa-cart-shopping'],
    ],
    'Industry' => [
        ['href' => '/industries/healthcare', 'label' => 'Healthcare', 'icon' => 'fa-solid fa-heart-pulse'],
        ['href' => '/industries/it-software-solutions-for-startups', 'label' => 'IT & Software Solutions for Startups', 'icon' => 'fa-solid fa-rocket'],
        ['href' => '/industries/finance-banking-software-development', 'label' => 'Finance & Banking', 'icon' => 'fa-solid fa-building-columns'],
        ['href' => '/industries/retail-ecommerce-solutions', 'label' => 'Retail & E-commerce', 'icon' => 'fa-solid fa-store'],
        ['href' => '/industries/logistics-supply-chain-apps', 'label' => 'Logistics & Supply Chain', 'icon' => 'fa-solid fa-truck'],
        ['href' => '/industries/education-elearning-platforms', 'label' => 'Education & E-learning', 'icon' => 'fa-solid fa-graduation-cap'],
    ],
];
?>
<div class="site-header__sentinel" aria-hidden="true" data-header-sentinel></div>
<header class="site-header relative z-20 w-full bg-transparent py-3">
    <div class="site-container flex items-center justify-between gap-3 sm:gap-4">
        <a href="/" class="site-header__logo inline-flex shrink-0" aria-label="Suave Creators home">
            <img src="/images/white_logo.svg" alt="Suave Creators" class="block h-9 w-auto object-contain sm:h-10">
        </a>

        <nav class="site-header__nav hidden items-center gap-10 xl:flex" aria-label="Main navigation">
            <a href="/about-us" class="whitespace-nowrap text-[13px] font-medium text-white transition hover:font-bold">About</a>
            <a href="/product" class="whitespace-nowrap text-[13px] font-medium text-white transition hover:font-bold">Product</a>

            <?php foreach ($dropdowns as $label => $items): ?>
                <div class="group relative">
                    <a href="/<?= strtolower($label) ?>"
                        class="inline-flex items-center gap-1.5 whitespace-nowrap text-[13px] font-medium text-white transition group-hover:font-semibold group-hover:text-[#8EB6FF]">
                        <?= htmlspecialchars($label) ?>
                        <i class="fa-solid fa-chevron-down text-[10px] transition duration-200 group-hover:rotate-180" aria-hidden="true"></i>
                    </a>

                    <div class="pointer-events-none invisible absolute left-1/2 top-full z-50 w-[320px] -translate-x-1/2 pt-3 opacity-0 transition duration-200 group-hover:pointer-events-auto group-hover:visible group-hover:opacity-100">
                        <div class="overflow-hidden rounded-[10px] border-t-[3px] border-[#5B8CFF] bg-white shadow-[0_12px_32px_rgba(15,23,42,0.16)] ring-1 ring-black/5">
                            <ul class="list-none p-0">
                                <?php foreach ($items as $index => $item): ?>
                                    <li class="<?= $index > 0 ? 'border-t border-[#EEF1F8]' : '' ?>">
                                        <a href="<?= htmlspecialchars($item['href']) ?>"
                                            class="group/item relative flex items-center gap-3 px-3 py-2 text-[13px] font-semibold text-[#0F172A] transition-colors hover:bg-[#F3F6FF]">
                                            <span class="absolute inset-y-0 left-0 w-[3px] origin-left scale-y-0 bg-[#2A4DFB] transition-transform duration-200 group-hover/item:scale-y-100" aria-hidden="true"></span>
                                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF0FF] text-[#2A4DFB]">
                                                <i class="<?= htmlspecialchars($item['icon']) ?> text-[13px]" aria-hidden="true"></i>
                                            </span>
                                            <span class="min-w-0 flex-1 leading-snug"><?= htmlspecialchars($item['label']) ?></span>
                                            <i class="fa-solid fa-chevron-right shrink-0 text-[10px] text-[#94A3B8] transition-transform duration-200 group-hover/item:translate-x-0.5 group-hover/item:text-[#2A4DFB]" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <a href="/blogs" class="whitespace-nowrap text-[13px] font-medium text-white transition hover:font-bold">Blog</a>
            <a href="/contact-us" class="whitespace-nowrap text-[13px] font-medium text-white transition hover:font-bold">Contact</a>
        </nav>

        <div class="site-header__actions flex items-center justify-end gap-2 sm:gap-4 xl:gap-5">
            <a href="tel:+918894900142" class="hidden shrink-0 whitespace-nowrap text-sm font-medium text-white hover:font-bold xl:inline">
                +91 88949 00142
            </a>
            <a href="/contact-us/#contact-id" class="site-header__cta u-btn-cta hidden shrink-0 items-center gap-1 rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-[14px] py-[8px] text-sm font-bold text-white transition hover:brightness-110 md:inline-flex md:px-[18px]">
                <span class="hidden lg:inline">Talk to an expert</span>
                <span class="lg:hidden">Talk to us</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 8L22 12L18 16" />
                    <path d="M2 12H22" />
                </svg>
            </a>
            <button type="button" id="mobile-nav-toggle" class="site-header__menu-btn u-touch-target inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-white transition hover:bg-white/10 xl:hidden" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-nav">
                <i class="fa-solid fa-bars text-xl site-header__menu-icon" aria-hidden="true"></i>
                <i class="fa-solid fa-xmark text-xl site-header__close-icon hidden" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div id="mobile-nav" class="mobile-nav" hidden>
        <div class="mobile-nav__backdrop" data-mobile-nav-close tabindex="-1" aria-hidden="true"></div>
        <div class="mobile-nav__panel" role="dialog" aria-modal="true" aria-label="Mobile navigation">
            <div class="mobile-nav__scroll">
                <nav class="mobile-nav__links" aria-label="Mobile navigation">
                    <a class="mobile-nav__link" href="/about-us">About</a>
                    <a class="mobile-nav__link" href="/product">Product</a>

                    <?php foreach ($dropdowns as $label => $items): ?>
                        <?php $dropdownId = 'mobile-nav-' . strtolower($label); ?>
                        <div class="mobile-nav__group">
                            <button type="button" class="mobile-nav__accordion" aria-expanded="false" aria-controls="<?= htmlspecialchars($dropdownId) ?>" id="<?= htmlspecialchars($dropdownId) ?>-btn">
                                <span><?= htmlspecialchars($label) ?></span>
                                <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                            </button>
                            <div id="<?= htmlspecialchars($dropdownId) ?>" class="mobile-nav__submenu" role="region" aria-labelledby="<?= htmlspecialchars($dropdownId) ?>-btn" hidden>
                                <?php foreach ($items as $item): ?>
                                    <a class="mobile-nav__sublink" href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['label']) ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <a class="mobile-nav__link" href="/blogs">Blog</a>
                    <a class="mobile-nav__link" href="/contact-us">Contact</a>
                </nav>

                <div class="mobile-nav__footer">
                    <a href="tel:+918894900142" class="mobile-nav__phone">+91 88949 00142</a>
                    <a href="/contact-us/#contact-id" class="mobile-nav__cta u-btn-cta !h-[34px] !min-h-[34px] !py-0 text-[13px]">
                        Talk to an expert
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 8L22 12L18 16" />
                            <path d="M2 12H22" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="site-header__spacer" aria-hidden="true" data-header-spacer></div>
<script>
(function () {
    var header = document.querySelector('.site-header');
    var sentinel = document.querySelector('[data-header-sentinel]');
    var spacer = document.querySelector('[data-header-spacer]');
    if (!header || !sentinel || !spacer) return;

    function syncSpacer() {
        spacer.style.height = header.classList.contains('is-stuck')
            ? header.getBoundingClientRect().height + 'px'
            : '';
    }

    function setStuck(isStuck) {
        if (header.classList.contains('is-stuck') === isStuck) return;
        header.classList.toggle('is-stuck', isStuck);
        syncSpacer();
    }

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (entries) {
            setStuck(!entries[0].isIntersecting);
        }, { threshold: 0 }).observe(sentinel);
    } else {
        window.addEventListener('scroll', function () {
            setStuck(sentinel.getBoundingClientRect().bottom <= 0);
        }, { passive: true });
    }

    window.addEventListener('resize', syncSpacer);
})();

(function () {
    var toggle = document.getElementById('mobile-nav-toggle');
    var nav = document.getElementById('mobile-nav');
    if (!toggle || !nav) return;

    var menuIcon = toggle.querySelector('.site-header__menu-icon');
    var closeIcon = toggle.querySelector('.site-header__close-icon');
    var closeTargets = nav.querySelectorAll('[data-mobile-nav-close]');
    var accordionButtons = nav.querySelectorAll('.mobile-nav__accordion');
    var desktopQuery = window.matchMedia('(min-width: 1280px)');

    function setOpen(isOpen) {
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        toggle.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');
        document.body.classList.toggle('mobile-nav-open', isOpen);

        if (isOpen) {
            nav.hidden = false;
            requestAnimationFrame(function () {
                nav.classList.add('is-open');
            });
        } else {
            nav.classList.remove('is-open');
            window.setTimeout(function () {
                if (!nav.classList.contains('is-open')) {
                    nav.hidden = true;
                }
            }, 280);
        }

        if (menuIcon && closeIcon) {
            menuIcon.classList.toggle('hidden', isOpen);
            closeIcon.classList.toggle('hidden', !isOpen);
        }
    }

    function closeNav() {
        setOpen(false);
    }

    function openNav() {
        setOpen(true);
    }

    toggle.addEventListener('click', function () {
        if (toggle.getAttribute('aria-expanded') === 'true') {
            closeNav();
        } else {
            openNav();
        }
    });

    closeTargets.forEach(function (el) {
        el.addEventListener('click', closeNav);
    });

    nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeNav);
    });

    accordionButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var panelId = button.getAttribute('aria-controls');
            var panel = panelId ? document.getElementById(panelId) : null;
            var willOpen = button.getAttribute('aria-expanded') !== 'true';

            accordionButtons.forEach(function (other) {
                var otherId = other.getAttribute('aria-controls');
                var otherPanel = otherId ? document.getElementById(otherId) : null;
                other.setAttribute('aria-expanded', 'false');
                other.classList.remove('is-open');
                if (otherPanel) otherPanel.hidden = true;
            });

            if (willOpen && panel) {
                button.setAttribute('aria-expanded', 'true');
                button.classList.add('is-open');
                panel.hidden = false;
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            closeNav();
            toggle.focus();
        }
    });

    function handleDesktopChange(event) {
        if (event.matches) closeNav();
    }

    if (desktopQuery.addEventListener) {
        desktopQuery.addEventListener('change', handleDesktopChange);
    } else if (desktopQuery.addListener) {
        desktopQuery.addListener(handleDesktopChange);
    }
})();
</script>
