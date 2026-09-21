(function () {
  var roots = document.querySelectorAll('[data-blog-share]');

  var setOpen = function (root, open) {
    var toggle = root.querySelector('[data-blog-share-toggle]');
    root.classList.toggle('is-open', open);
    if (toggle) {
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
  };

  roots.forEach(function (root) {
    var toggle = root.querySelector('[data-blog-share-toggle]');
    if (toggle) {
      toggle.addEventListener('click', function (event) {
        event.stopPropagation();
        setOpen(root, !root.classList.contains('is-open'));
      });
    }

    root.querySelectorAll('[data-blog-share-copy]').forEach(function (button) {
      button.addEventListener('click', function () {
        var url = button.getAttribute('data-url') || window.location.href;
        var copied = root.querySelector('[data-blog-share-copied]');
        var showCopied = function () {
          if (!copied) return;
          copied.hidden = false;
          window.setTimeout(function () { copied.hidden = true; }, 2000);
        };
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(url).then(showCopied).catch(function () {
            window.prompt('Copy this link', url);
          });
          return;
        }
        window.prompt('Copy this link', url);
      });
    });
  });

  document.addEventListener('click', function (event) {
    roots.forEach(function (root) {
      if (!root.contains(event.target)) {
        setOpen(root, false);
      }
    });
  });

  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    roots.forEach(function (root) {
      setOpen(root, false);
    });
  });

  var agent = document.querySelector('[data-suave-agent]');
  if (agent && window.MutationObserver) {
    new MutationObserver(function () {
      if (agent.classList.contains('is-open')) {
        roots.forEach(function (root) {
          setOpen(root, false);
        });
      }
    }).observe(agent, { attributes: true, attributeFilter: ['class'] });
  }
})();
