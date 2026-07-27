<script>
  (function () {
    const STORAGE_KEY = 'suave-admin-sidebar-collapsed';
    const app = document.querySelector('[data-admin-app]');
    if (!app) return;

    const sidebar = app.querySelector('[data-admin-sidebar]');
    const backdrop = app.querySelector('[data-admin-backdrop]');
    const toggle = app.querySelector('[data-admin-menu]');

    const isDesktop = () => window.matchMedia('(min-width: 1024px)').matches;

    const setMobileOpen = (open) => {
      sidebar?.classList.toggle('is-open', open);
      backdrop?.classList.toggle('is-open', open);
      document.body.style.overflow = open ? 'hidden' : '';
    };

    const setCollapsed = (collapsed) => {
      app.classList.toggle('is-sidebar-collapsed', collapsed);
      try {
        localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
      } catch (e) {
        // Ignore storage failures (private mode, etc.).
      }
      if (toggle) {
        toggle.setAttribute('aria-label', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
        toggle.setAttribute('title', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
      }
    };

    try {
      if (localStorage.getItem(STORAGE_KEY) === '1') {
        app.classList.add('is-sidebar-collapsed');
      }
    } catch (e) {
      // Ignore.
    }

    if (toggle && app.classList.contains('is-sidebar-collapsed')) {
      toggle.setAttribute('aria-label', 'Expand sidebar');
      toggle.setAttribute('title', 'Expand sidebar');
    }

    toggle?.addEventListener('click', () => {
      if (isDesktop()) {
        setCollapsed(!app.classList.contains('is-sidebar-collapsed'));
        return;
      }
      setMobileOpen(!sidebar.classList.contains('is-open'));
    });

    backdrop?.addEventListener('click', () => setMobileOpen(false));

    window.addEventListener('resize', () => {
      if (isDesktop()) {
        setMobileOpen(false);
      }
    });

    const userMenu = app.querySelector('[data-admin-user-menu]');
    const userToggle = app.querySelector('[data-admin-user-toggle]');
    const userDropdown = app.querySelector('[data-admin-user-dropdown]');

    const setUserMenuOpen = (open) => {
      if (!userMenu || !userToggle || !userDropdown) return;
      userMenu.classList.toggle('is-open', open);
      userToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (open) {
        userDropdown.removeAttribute('hidden');
      } else {
        userDropdown.setAttribute('hidden', '');
      }
    };

    userToggle?.addEventListener('click', (event) => {
      event.stopPropagation();
      setUserMenuOpen(!userMenu.classList.contains('is-open'));
    });

    document.addEventListener('click', (event) => {
      if (!userMenu?.contains(event.target)) {
        setUserMenuOpen(false);
      }
    });

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        setMobileOpen(false);
        setUserMenuOpen(false);
      }
    });
  })();
</script>
