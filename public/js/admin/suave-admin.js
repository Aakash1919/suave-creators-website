/**
 * Suave Admin reusable helpers — Toastr, AJAX forms, DataTables, deletes.
 * Requires: jQuery, toastr, DataTables (when using initDataTable).
 *
 * @see https://codeseven.github.io/toastr/
 */
(function (window, $) {
  'use strict';

  if (!$) {
    console.error('SuaveAdmin requires jQuery.');
    return;
  }

  const csrfToken = () =>
    $('meta[name="csrf-token"]').attr('content') ||
    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
    '';

  /**
   * Show a Toastr flash message.
   * Types: success|status|error|danger|warning|info
   */
  function createFlashMessage(type, message, title) {
    if (!message || !window.toastr) {
      return;
    }

    const normalized = String(type || 'info').toLowerCase();
    const methodMap = {
      success: 'success',
      status: 'success',
      ok: 'success',
      error: 'error',
      danger: 'error',
      fail: 'error',
      warning: 'warning',
      warn: 'warning',
      info: 'info',
    };
    const method = methodMap[normalized] || 'info';
    const defaultTitles = {
      success: 'Success',
      error: 'Error',
      warning: 'Warning',
      info: 'Info',
    };

    toastr[method](message, title ?? defaultTitles[method]);
  }

  const toast = {
    success(message, title = 'Success') {
      createFlashMessage('success', message, title);
    },
    error(message, title = 'Error') {
      createFlashMessage('error', message, title);
    },
    warning(message, title = 'Warning') {
      createFlashMessage('warning', message, title);
    },
    info(message, title = 'Info') {
      createFlashMessage('info', message, title);
    },
    /** Show validation messages from a Laravel 422 JSON payload. */
    validation(xhrOrErrors, fallback = 'Please fix the highlighted errors.') {
      let errors = xhrOrErrors;

      if (xhrOrErrors && xhrOrErrors.responseJSON) {
        errors = xhrOrErrors.responseJSON.errors || xhrOrErrors.responseJSON;
      }

      if (errors && typeof errors === 'object' && !Array.isArray(errors)) {
        const messages = [];
        Object.keys(errors).forEach((key) => {
          const value = errors[key];
          if (Array.isArray(value)) {
            value.forEach((msg) => messages.push(msg));
          } else if (typeof value === 'string') {
            messages.push(value);
          }
        });

        if (messages.length) {
          messages.forEach((msg) => createFlashMessage('error', msg));
          return;
        }
      }

      if (typeof xhrOrErrors === 'string') {
        createFlashMessage('error', xhrOrErrors);
        return;
      }

      const message =
        xhrOrErrors?.responseJSON?.message ||
        xhrOrErrors?.statusText ||
        fallback;
      createFlashMessage('error', message);
    },
    /** Emit flash toasts from server-rendered flash payload. */
    fromFlash(flashes) {
      if (!flashes) return;
      if (flashes.status) createFlashMessage('success', flashes.status);
      if (flashes.error) createFlashMessage('error', flashes.error);
      if (flashes.warning) createFlashMessage('warning', flashes.warning);
      if (flashes.info) createFlashMessage('info', flashes.info);
      if (Array.isArray(flashes.errors)) {
        flashes.errors.forEach((msg) => createFlashMessage('error', msg));
      }
    },
  };

  function configureToastr(options = {}) {
    if (!window.toastr) return;
    toastr.options = Object.assign(
      {
        closeButton: true,
        progressBar: true,
        newestOnTop: true,
        positionClass: 'toast-top-right',
        timeOut: 4000,
        extendedTimeOut: 1500,
        showDuration: 200,
        hideDuration: 200,
        preventDuplicates: true,
      },
      options
    );
  }

  function ajax(options) {
    const defaults = {
      headers: {
        'X-CSRF-TOKEN': csrfToken(),
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
      },
    };

    return $.ajax(Object.assign({}, defaults, options, {
      headers: Object.assign({}, defaults.headers, options.headers || {}),
    }));
  }

  const richTextEditors = {};

  /**
   * Read HTML from a RichTextEditor instance across API variants.
   */
  function readRichTextHtml(editor) {
    if (!editor) {
      return '';
    }

    const getters = ['getHTMLCode', 'getHtmlCode', 'getHTMLContent', 'getHTML', 'getHtml', 'getContent'];
    for (let i = 0; i < getters.length; i += 1) {
      const method = getters[i];
      if (typeof editor[method] === 'function') {
        try {
          const html = editor[method]();
          if (typeof html === 'string') {
            return html;
          }
        } catch (e) {
          /* try next */
        }
      }
    }

    if (typeof editor.getDocument === 'function') {
      try {
        const doc = editor.getDocument();
        if (doc?.body?.innerHTML) {
          return doc.body.innerHTML;
        }
      } catch (e) {
        /* ignore */
      }
    }

    const root = editor.iframe || editor.contentWindow || editor.editor || null;
    try {
      if (root?.contentDocument?.body?.innerHTML) {
        return root.contentDocument.body.innerHTML;
      }
      if (root?.document?.body?.innerHTML) {
        return root.document.body.innerHTML;
      }
      if (typeof root?.innerHTML === 'string') {
        return root.innerHTML;
      }
    } catch (e) {
      /* ignore */
    }

    return '';
  }

  /**
   * Write HTML into a RichTextEditor instance across API variants.
   */
  function writeRichTextHtml(editor, html) {
    if (!editor || html == null) {
      return false;
    }

    const setters = ['setHTMLCode', 'setHtmlCode', 'setHTML', 'setHtml', 'setContent'];
    for (let i = 0; i < setters.length; i += 1) {
      const method = setters[i];
      if (typeof editor[method] === 'function') {
        try {
          editor[method](html);
          return true;
        } catch (e) {
          /* try next */
        }
      }
    }

    return false;
  }

  /**
   * Keep the underlying textarea value in sync with the editor.
   */
  function bindRichTextTextareaSync(editor, el) {
    const sync = function () {
      const html = readRichTextHtml(editor);
      if (typeof html === 'string') {
        el.value = html;
      }
    };

    const events = ['change', 'contentchanged', 'selectionchanged', 'exec_command', 'paste'];
    events.forEach(function (name) {
      if (typeof editor.attachEvent === 'function') {
        try {
          editor.attachEvent(name, sync);
        } catch (e) {
          /* ignore */
        }
      }
      if (typeof editor.on === 'function') {
        try {
          editor.on(name, sync);
        } catch (e) {
          /* ignore */
        }
      }
    });

    window.setInterval(sync, 1500);
  }

  /**
   * Initialize RichTextEditor on a textarea/div (self-hosted under /richtexteditor).
   * @see https://richtexteditor.com/
   */
  function initRichTextEditor(selector, options = {}) {
    if (typeof window.RichTextEditor !== 'function') {
      console.error('RichTextEditor is not loaded. Include layouts.admin.partials.richtexteditor.');
      return null;
    }

    const el = document.querySelector(selector);
    if (!el) {
      console.error('RichTextEditor target missing:', selector);
      return null;
    }

    const initialHtml = typeof el.value === 'string' ? el.value : (el.innerHTML || '');

    const cfg = Object.assign(
      {
        height: 560,
        toolbar: 'blog',
      },
      options
    );

    if (cfg.toolbar === 'blog' && window.RTE_DefaultConfig?.toolbar_blog && !cfg.toolbar_blog) {
      cfg.toolbar_blog = window.RTE_DefaultConfig.toolbar_blog;
    }

    const editor = new window.RichTextEditor(selector, cfg);
    richTextEditors[selector] = editor;
    $(el).attr('data-richtext-editor', '1').data('rte-instance', editor);
    $(el).data('rte-selector', selector);

    const seed = function () {
      if (initialHtml && initialHtml.trim() !== '') {
        const current = readRichTextHtml(editor);
        const looksEmpty =
          !current ||
          current.trim() === '' ||
          current.trim() === '<p></p>' ||
          current.trim() === '<br>' ||
          current.trim() === '<p><br></p>';
        if (looksEmpty) {
          writeRichTextHtml(editor, initialHtml);
        }
        el.value = initialHtml;
      }
      bindRichTextTextareaSync(editor, el);
    };

    window.setTimeout(seed, 0);
    window.setTimeout(seed, 150);

    return editor;
  }

  function getRichTextEditor(selector) {
    if (richTextEditors[selector]) {
      return richTextEditors[selector];
    }
    const el = document.querySelector(selector);
    return el ? $(el).data('rte-instance') : null;
  }

  /** Copy editor HTML back into underlying textareas before FormData / submit. */
  function syncRichTextEditors(root = document) {
    Object.keys(richTextEditors).forEach(function (selector) {
      const editor = richTextEditors[selector];
      const el = document.querySelector(selector);
      if (!editor || !el) {
        return;
      }
      const html = readRichTextHtml(editor);
      if (typeof html === 'string') {
        el.value = html;
      }
    });

    $(root)
      .find('[data-richtext-editor]')
      .addBack('[data-richtext-editor]')
      .each(function () {
        const editor = $(this).data('rte-instance') || richTextEditors[$(this).data('rte-selector')];
        if (!editor) {
          return;
        }
        const html = readRichTextHtml(editor);
        if (typeof html === 'string') {
          this.value = html;
        }
      });
  }

  /**
   * Toggle submit-button loading UI (spinner + label) for AJAX forms.
   */
  function setSubmitLoading($buttons, loading) {
    $buttons.each(function () {
      const $btn = $(this);
      if (loading) {
        if ($btn.data('original-html') == null) {
          $btn.data('original-html', $btn.html());
        }
        const loadingText =
          $btn.data('loading-text') ||
          $btn.closest('form').data('loading-text') ||
          'Please wait…';
        $btn
          .addClass('is-loading')
          .prop('disabled', true)
          .attr('aria-busy', 'true')
          .html('<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> ' + loadingText);
        return;
      }

      const original = $btn.data('original-html');
      if (original != null) {
        $btn.html(original);
        $btn.removeData('original-html');
      }
      $btn.removeClass('is-loading').prop('disabled', false).removeAttr('aria-busy');
    });
  }

  /**
   * Submit a form via AJAX (supports multipart / file uploads).
   * Form may use data-ajax-form, data-success-message, data-reload-table,
   * data-loading-text (or on the submit button).
   */
  function submitForm($form, options = {}) {
    const form = $form instanceof $ ? $form : $($form);
    const opts = Object.assign(
      {
        successMessage: form.data('success-message') || null,
        reloadTable: form.data('reload-table') || null,
        redirect: form.data('redirect') !== false,
        beforeSend: null,
        onSuccess: null,
        onError: null,
      },
      options
    );

    syncRichTextEditors(form);

    const method = (form.find('input[name="_method"]').val() || form.attr('method') || 'POST').toUpperCase();
    const url = form.attr('action');
    const formData = new FormData(form[0]);

    if (!formData.has('_ajax')) {
      formData.append('_ajax', '1');
    }

    const $submit = form.find('[type="submit"]');
    setSubmitLoading($submit, true);

    return ajax({
      url,
      method: method === 'GET' ? 'GET' : 'POST',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: opts.beforeSend,
    })
      .done(function (response) {
        const message = response?.message || opts.successMessage || 'Saved successfully.';
        createFlashMessage('success', message);

        if (typeof opts.onSuccess === 'function') {
          opts.onSuccess(response);
        }

        if (opts.reloadTable) {
          reloadDataTable(opts.reloadTable);
        }

        const closeModalSel = form.attr('data-close-modal') || form.data('close-modal');
        if (closeModalSel) {
          closeAdminModal(closeModalSel);
        }

        if (opts.redirect !== false && response?.redirect) {
          window.setTimeout(function () {
            window.location.href = response.redirect;
          }, 450);
        }
      })
      .fail(function (xhr) {
        toast.validation(xhr);
        if (typeof opts.onError === 'function') {
          opts.onError(xhr);
        }
      })
      .always(function () {
        setSubmitLoading($submit, false);
      });
  }

  /**
   * Initialize a Yajra-compatible DataTable (admin list layout).
   */
  function initDataTable(selector, options = {}) {
    const $table = $(selector);
    if (!$table.length || !$.fn.DataTable) {
      console.error('DataTable target or plugin missing:', selector);
      return null;
    }

    if ($.fn.DataTable.isDataTable($table)) {
      $table.DataTable().destroy();
    }

    const shell = $table.closest('[data-admin-datatable]')[0] || null;

    const defaults = {
      processing: true,
      serverSide: true,
      // Horizontal scroll inside the table card — do not expand the page content area.
      scrollX: true,
      responsive: false,
      autoWidth: false,
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      order: [[0, 'desc']],
      language: {
        processing: '<div class="admin-dt-loader"><i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i><span>Loading…</span></div>',
        emptyTable: 'No records found.',
        zeroRecords: 'No matching records.',
        lengthMenu: '_MENU_',
        paginate: {
          previous: '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>',
          next: '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>',
        },
      },
      dom: 'rt<"admin-dt__footer"<"admin-dt__footer-left"l><"admin-dt__footer-right"p>>',
    };

    const settings = Object.assign({}, defaults, options);
    if (settings.ajax && typeof settings.ajax === 'object') {
      settings.ajax.headers = Object.assign(
        {
          'X-CSRF-TOKEN': csrfToken(),
          'X-Requested-With': 'XMLHttpRequest',
          Accept: 'application/json',
        },
        settings.ajax.headers || {}
      );
    }

    const table = $table.DataTable(settings);
    $table.data('suave-datatable', table);

    const $wrapper = $table.closest('.dataTables_wrapper');
    $table.off('processing.dt.suaveLoader').on('processing.dt.suaveLoader', function (_e, _settings, processing) {
      $wrapper.toggleClass('is-processing', Boolean(processing));
    });

    enhanceAdminDataTable(table, $table, shell);

    // Keep wide tables scrolling inside the card; remeasure after layout settles.
    window.setTimeout(function () {
      if (table && typeof table.columns === 'function') {
        table.columns.adjust();
      }
    }, 50);

    return table;
  }

  function enhanceAdminDataTable(table, $table, shell) {
    const $wrapper = $table.closest('.dataTables_wrapper');
    if (!$wrapper.length) {
      return;
    }

    const $length = $wrapper.find('.dataTables_length');
    if ($length.length) {
      $length.find('label').contents().filter(function () {
        return this.nodeType === 3;
      }).remove();
      if (!$length.find('.admin-dt-length-prefix').length) {
        $length.find('label').prepend('<span class="admin-dt-length-prefix">Rows Per Page</span> ');
        $length.find('label').append(' <span class="admin-dt-length-suffix">Entries</span>');
      }
    }

    if (!shell) {
      return;
    }

    const $shell = $(shell);
    let searchTimer = null;

    $shell.find('[data-dt-search]').off('input.suaveDtSearch').on('input.suaveDtSearch', function () {
      const value = this.value;
      window.clearTimeout(searchTimer);
      searchTimer = window.setTimeout(function () {
        table.search(value).draw();
      }, 250);
    });

    $shell.find('[data-dt-sort-option]').off('click.suaveDtSort').on('click.suaveDtSort', function () {
      const $btn = $(this);
      const column = Number($btn.attr('data-column')) || 0;
      const dir = $btn.attr('data-dir') === 'asc' ? 'asc' : 'desc';
      const label = ($btn.text() || '').trim();

      $shell.find('[data-dt-sort-option]').removeClass(
        'bg-[var(--admin-primary)] text-white hover:bg-[var(--admin-primary)] hover:text-white'
      );
      $btn.addClass('bg-[var(--admin-primary)] text-white hover:bg-[var(--admin-primary)] hover:text-white');

      if (label) {
        $shell.find('[data-dt-sort-label]').text('Sort By: ' + label);
      }

      const details = $btn.closest('details')[0];
      if (details) {
        details.open = false;
      }

      table.order([[column, dir]]).draw();
    });

    $shell.find('[data-dt-col]').off('change.suaveDtCol').on('change.suaveDtCol', function () {
      const index = Number(this.getAttribute('data-dt-col'));
      if (Number.isNaN(index)) {
        return;
      }
      table.column(index).visible(this.checked);
    });
  }

  function reloadDataTable(selectorOrInstance, resetPaging = false) {
    let table = selectorOrInstance;

    if (typeof selectorOrInstance === 'string' || selectorOrInstance instanceof $ || selectorOrInstance?.jquery) {
      const $el = $(selectorOrInstance);
      table = $el.data('suave-datatable') || ($.fn.DataTable.isDataTable($el) ? $el.DataTable() : null);
    }

    if (table && typeof table.ajax === 'object' && typeof table.ajax.reload === 'function') {
      table.ajax.reload(null, resetPaging);
    }
  }

  function confirmDialog(options = {}) {
    const opts = Object.assign(
      {
        title: 'Are you sure?',
        message: 'This action cannot be undone.',
        confirmText: 'Confirm',
        cancelText: 'Cancel',
        danger: false,
      },
      options
    );

    const root = document.querySelector('[data-admin-confirm]');
    if (!root) {
      return Promise.resolve(window.confirm([opts.title, opts.message].filter(Boolean).join('\n')));
    }

    const dialog = root.querySelector('[data-admin-confirm-dialog]') || root.querySelector('.admin-confirm__dialog');
    const titleEl = root.querySelector('[data-admin-confirm-title]');
    const messageEl = root.querySelector('[data-admin-confirm-message]');
    const okBtn = root.querySelector('[data-admin-confirm-ok]');
    const cancelBtn = root.querySelector('[data-admin-confirm-cancel]');
    const backdrop = root.querySelector('[data-admin-confirm-backdrop]');
    const icon = root.querySelector('[data-admin-confirm-icon]');
    const iconGlyph = root.querySelector('[data-admin-confirm-icon-glyph]');

    if (titleEl) titleEl.textContent = opts.title;
    if (messageEl) messageEl.textContent = opts.message;
    if (okBtn) {
      okBtn.textContent = opts.confirmText;
      okBtn.classList.toggle('admin-btn--danger', !!opts.danger);
      okBtn.classList.toggle('admin-btn--primary', !opts.danger);
    }
    if (cancelBtn) cancelBtn.textContent = opts.cancelText;
    if (dialog) dialog.classList.toggle('admin-confirm__dialog--danger', !!opts.danger);
    if (icon) icon.classList.toggle('admin-confirm__icon--danger', !!opts.danger);
    if (iconGlyph) {
      iconGlyph.className = opts.danger
        ? 'fa-solid fa-triangle-exclamation'
        : 'fa-solid fa-circle-question';
    }

    return new Promise(function (resolve) {
      const previouslyFocused = document.activeElement;
      let settled = false;

      const close = (result) => {
        if (settled) return;
        settled = true;
        root.classList.remove('is-open');
        document.body.classList.remove('admin-confirm-open');
        document.removeEventListener('keydown', onKeyDown);
        okBtn?.removeEventListener('click', onOk);
        cancelBtn?.removeEventListener('click', onCancel);
        backdrop?.removeEventListener('click', onCancel);

        window.setTimeout(function () {
          root.setAttribute('hidden', '');
          if (previouslyFocused && typeof previouslyFocused.focus === 'function') {
            previouslyFocused.focus();
          }
          resolve(result);
        }, 160);
      };

      const onOk = (event) => {
        event.preventDefault();
        close(true);
      };
      const onCancel = (event) => {
        event.preventDefault();
        close(false);
      };
      const onKeyDown = (event) => {
        if (event.key === 'Escape') {
          event.preventDefault();
          close(false);
          return;
        }
        if (event.key === 'Enter' && !event.shiftKey && !event.altKey && !event.ctrlKey && !event.metaKey) {
          const tag = (document.activeElement && document.activeElement.tagName) || '';
          if (tag === 'TEXTAREA' || tag === 'BUTTON') return;
          event.preventDefault();
          close(true);
        }
      };

      okBtn?.addEventListener('click', onOk);
      cancelBtn?.addEventListener('click', onCancel);
      backdrop?.addEventListener('click', onCancel);
      document.addEventListener('keydown', onKeyDown);

      root.removeAttribute('hidden');
      document.body.classList.add('admin-confirm-open');
      document.querySelectorAll('details[open]').forEach(function (el) {
        el.open = false;
      });

      // Next frame so CSS transitions run from the closed state.
      window.requestAnimationFrame(function () {
        root.classList.add('is-open');
      });

      window.setTimeout(function () {
        (opts.danger ? cancelBtn : okBtn)?.focus();
      }, 30);
    });
  }

  function destroyRecord(url, options = {}) {
    const opts = Object.assign(
      {
        confirm: 'Are you sure you want to delete this record?',
        confirmTitle: 'Delete record?',
        confirmLabel: 'Delete',
        successMessage: 'Deleted successfully.',
        reloadTable: null,
        redirect: null,
        method: 'DELETE',
      },
      options
    );

    const deferred = $.Deferred();

    const runDelete = function () {
      ajax({
        url,
        method: 'POST',
        data: {
          _method: opts.method,
          _ajax: 1,
          _token: csrfToken(),
        },
      })
        .done(function (response) {
          const message = response?.message || opts.successMessage;
          createFlashMessage('success', message);
          if (opts.reloadTable) {
            reloadDataTable(opts.reloadTable);
          }
          if (response?.redirect || opts.redirect) {
            window.setTimeout(function () {
              window.location.href = response?.redirect || opts.redirect;
            }, 400);
          }
          deferred.resolve(response);
        })
        .fail(function (xhr) {
          toast.validation(xhr, 'Unable to delete this record.');
          deferred.reject(xhr);
        });
    };

    if (!opts.confirm) {
      runDelete();
      return deferred.promise();
    }

    confirmDialog({
      title: opts.confirmTitle || 'Are you sure?',
      message: typeof opts.confirm === 'string' ? opts.confirm : 'This action cannot be undone.',
      confirmText: opts.confirmLabel || 'Delete',
      cancelText: 'Cancel',
      danger: true,
    }).then(function (ok) {
      if (ok) {
        runDelete();
      } else {
        deferred.reject();
      }
    });

    return deferred.promise();
  }

  function bindAjaxForms(root = document) {
    $(root)
      .off('submit.suaveAdmin', '[data-ajax-form]')
      .on('submit.suaveAdmin', '[data-ajax-form]', function (event) {
        event.preventDefault();
        submitForm($(this));
      });
  }

  function bindDeleteButtons(root = document) {
    $(root)
      .off('click.suaveAdmin', '[data-admin-delete]')
      .on('click.suaveAdmin', '[data-admin-delete]', function (event) {
        event.preventDefault();
        const $btn = $(this);
        const reloadAttr = $btn.attr('data-reload-table');
        let reloadTable = '#admin-datatable';
        if (reloadAttr === '') {
          reloadTable = null;
        } else if (typeof reloadAttr === 'string') {
          reloadTable = reloadAttr;
        }

        destroyRecord($btn.data('url'), {
          confirm: $btn.data('confirm') || 'This action cannot be undone.',
          confirmTitle: $btn.data('confirm-title') || 'Delete record?',
          confirmLabel: $btn.data('confirm-label') || 'Delete',
          reloadTable,
          successMessage: $btn.data('success-message') || 'Deleted successfully.',
        });
      });
  }

  function bindDetailsOutsideClose() {
    if (document.documentElement.dataset.suaveDetailsBound === '1') {
      return;
    }
    document.documentElement.dataset.suaveDetailsBound = '1';

    document.addEventListener('click', function (event) {
      const path = typeof event.composedPath === 'function' ? event.composedPath() : [];

      document.querySelectorAll('details[open]').forEach(function (details) {
        if (details.hasAttribute('data-details-persist')) {
          return;
        }

        const clickedInside =
          details.contains(event.target) ||
          path.indexOf(details) !== -1;

        if (!clickedInside) {
          details.open = false;
        }
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key !== 'Escape') {
        return;
      }
      document.querySelectorAll('details[open]').forEach(function (details) {
        if (details.hasAttribute('data-details-persist')) {
          return;
        }
        details.open = false;
      });
    });
  }

  function formatDateLabel(date) {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const d = date instanceof Date ? date : new Date(date);
    const dd = String(d.getDate()).padStart(2, '0');
    const mon = months[d.getMonth()];
    const yy = String(d.getFullYear()).slice(-2);
    return `${dd} ${mon} ${yy}`;
  }

  function toYmd(date) {
    const d = date instanceof Date ? date : new Date(date);
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
  }

  function startOfDay(date) {
    const d = new Date(date);
    d.setHours(0, 0, 0, 0);
    return d;
  }

  function endOfDay(date) {
    const d = new Date(date);
    d.setHours(23, 59, 59, 999);
    return d;
  }

  function resolveDatePreset(preset, customFrom = null, customTo = null) {
    const today = startOfDay(new Date());
    let from = today;
    let to = today;

    switch (preset) {
      case 'today':
        break;
      case 'yesterday':
        from = new Date(today);
        from.setDate(from.getDate() - 1);
        to = new Date(from);
        break;
      case 'last_7_days':
        from = new Date(today);
        from.setDate(from.getDate() - 6);
        break;
      case 'last_30_days':
        from = new Date(today);
        from.setDate(from.getDate() - 29);
        break;
      case 'this_month':
        from = new Date(today.getFullYear(), today.getMonth(), 1);
        break;
      case 'last_month':
        from = new Date(today.getFullYear(), today.getMonth() - 1, 1);
        to = new Date(today.getFullYear(), today.getMonth(), 0);
        break;
      case 'custom':
        from = customFrom ? startOfDay(customFrom) : today;
        to = customTo ? startOfDay(customTo) : from;
        break;
      default:
        from = new Date(today);
        from.setDate(from.getDate() - 29);
        break;
    }

    return { from: startOfDay(from), to: startOfDay(to), preset };
  }

  /**
   * Admin date range filter with presets + Flatpickr custom range.
   */
  function initDateRangeFilter(selector, options = {}) {
    const root = typeof selector === 'string' ? document.querySelector(selector) : selector;
    if (!root) {
      console.error('Date range filter missing:', selector);
      return null;
    }

    const opts = Object.assign(
      {
        defaultPreset: root.getAttribute('data-default-preset') || 'last_30_days',
        onChange: null,
      },
      options
    );

    const trigger = root.querySelector('[data-daterange-trigger]');
    const menu = root.querySelector('[data-daterange-menu]');
    const label = root.querySelector('[data-daterange-label]');
    const fromInput = root.querySelector('[data-daterange-from]');
    const toInput = root.querySelector('[data-daterange-to]');
    const presetInput = root.querySelector('[data-daterange-preset]');
    const pickerInput = root.querySelector('[data-daterange-picker]');
    const optionButtons = Array.from(root.querySelectorAll('[data-preset]'));

    let state = resolveDatePreset(opts.defaultPreset);
    let picker = null;

    const setMenuOpen = (open) => {
      root.classList.toggle('is-open', open);
      trigger?.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (!menu) return;
      if (open) {
        menu.removeAttribute('hidden');
      } else {
        menu.setAttribute('hidden', '');
      }
    };

    const paint = () => {
      if (label) {
        label.textContent = `${formatDateLabel(state.from)} - ${formatDateLabel(state.to)}`;
      }
      if (fromInput) fromInput.value = toYmd(state.from);
      if (toInput) toInput.value = toYmd(state.to);
      if (presetInput) presetInput.value = state.preset;

      optionButtons.forEach((btn) => {
        btn.classList.toggle('is-active', btn.getAttribute('data-preset') === state.preset);
      });
    };

    const emitChange = () => {
      if (typeof opts.onChange === 'function') {
        opts.onChange({
          from: toYmd(state.from),
          to: toYmd(state.to),
          preset: state.preset,
        });
      }
    };

    const applyPreset = (preset, customFrom = null, customTo = null, emit = true) => {
      state = resolveDatePreset(preset, customFrom, customTo);
      paint();
      setMenuOpen(false);
      if (emit) {
        emitChange();
      }
    };

    const openCustomPicker = () => {
      setMenuOpen(false);
      if (!pickerInput || typeof window.flatpickr !== 'function') {
        applyPreset('custom');
        return;
      }

      if (!picker) {
        picker = window.flatpickr(pickerInput, {
          mode: 'range',
          dateFormat: 'Y-m-d',
          allowInput: false,
          disableMobile: true,
          defaultDate: [state.from, state.to],
          positionElement: trigger || pickerInput,
          onClose: function (selectedDates) {
            if (selectedDates.length === 2) {
              applyPreset('custom', selectedDates[0], selectedDates[1]);
            }
          },
        });
      } else {
        picker.setDate([state.from, state.to], false);
      }

      picker.open();
    };

    trigger?.addEventListener('click', (event) => {
      event.stopPropagation();
      setMenuOpen(!root.classList.contains('is-open'));
    });

    optionButtons.forEach((btn) => {
      btn.addEventListener('click', (event) => {
        event.preventDefault();
        const preset = btn.getAttribute('data-preset');
        if (preset === 'custom') {
          openCustomPicker();
          return;
        }
        applyPreset(preset);
      });
    });

    document.addEventListener('click', (event) => {
      if (!root.contains(event.target)) {
        setMenuOpen(false);
      }
    });

    applyPreset(opts.defaultPreset, null, null, false);

    const api = {
      getRange: () => ({
        from: toYmd(state.from),
        to: toYmd(state.to),
        preset: state.preset,
      }),
      setPreset: (preset) => applyPreset(preset),
      root,
    };

    $(root).data('daterange-api', api);
    return api;
  }

  /**
   * Initialize Flatpickr on a selector (CDN: https://flatpickr.js.org/).
   */
  function initFlatpickr(selector, options = {}) {
    if (typeof window.flatpickr !== 'function') {
      console.error('Flatpickr is not loaded.');
      return null;
    }

    const el = typeof selector === 'string' ? document.querySelector(selector) : selector;
    if (!el) {
      console.error('Flatpickr target missing:', selector);
      return null;
    }

    if (el._flatpickr) {
      el._flatpickr.destroy();
    }

    const defaults = {
      allowInput: true,
      disableMobile: true,
      dateFormat: 'Y-m-d',
      altInput: false,
    };

    const instance = window.flatpickr(el, Object.assign({}, defaults, options));
    $(el).data('flatpickr-instance', instance);
    return instance;
  }

  /**
   * Read data-flatpickr-* attributes into Flatpickr options.
   */
  function flatpickrOptionsFromElement(el) {
    const $el = $(el);
    const options = {};

    const dateFormat = $el.attr('data-flatpickr-date-format');
    if (dateFormat) {
      options.dateFormat = dateFormat;
    }

    if ($el.attr('data-flatpickr-enable-time') === 'true') {
      options.enableTime = true;
      options.time_24hr = $el.attr('data-flatpickr-time-24hr') !== 'false';
      if (!dateFormat) {
        options.dateFormat = 'Y-m-d H:i';
      }
    }

    if ($el.attr('data-flatpickr-no-calendar') === 'true') {
      options.noCalendar = true;
      options.enableTime = true;
    }

    if ($el.attr('data-flatpickr-mode')) {
      options.mode = $el.attr('data-flatpickr-mode');
    }

    if ($el.attr('data-flatpickr-min-date')) {
      options.minDate = $el.attr('data-flatpickr-min-date');
    }

    if ($el.attr('data-flatpickr-max-date')) {
      options.maxDate = $el.attr('data-flatpickr-max-date');
    }

    if ($el.attr('data-flatpickr-alt-format')) {
      options.altInput = true;
      options.altFormat = $el.attr('data-flatpickr-alt-format');
    }

    return options;
  }

  /** Auto-bind all [data-flatpickr] fields in a root. */
  function bindFlatpickrs(root = document) {
    $(root)
      .find('[data-flatpickr]')
      .addBack('[data-flatpickr]')
      .each(function () {
        initFlatpickr(this, flatpickrOptionsFromElement(this));
      });
  }

  function slugifyAnchor(value) {
    return String(value || '')
      .toLowerCase()
      .trim()
      .replace(/['"]/g, '')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '')
      .slice(0, 160);
  }

  function reindexRepeater(root) {
    const name = root.getAttribute('data-name') || 'items';
    const rows = root.querySelectorAll('[data-repeater-row]');
    rows.forEach(function (row, index) {
      row.querySelectorAll('[name]').forEach(function (field) {
        const current = field.getAttribute('name') || '';
        field.setAttribute(
          'name',
          current.replace(new RegExp('^' + name + '\\[\\d+\\]'), name + '[' + index + ']')
            .replace(name + '[__INDEX__]', name + '[' + index + ']')
        );
      });
    });
  }

  function wireTocAnchor(row) {
    const label = row.querySelector('[data-repeater-toc-label]');
    const anchor = row.querySelector('[data-repeater-toc-anchor]');
    if (!label || !anchor) {
      return;
    }

    if (anchor.value.trim() !== '') {
      anchor.dataset.manual = '1';
    }

    label.addEventListener('input', function () {
      if (anchor.dataset.manual === '1' && anchor.value.trim() !== '') {
        return;
      }
      anchor.value = slugifyAnchor(label.value);
      anchor.dataset.manual = '0';
    });

    anchor.addEventListener('input', function () {
      anchor.dataset.manual = anchor.value.trim() === '' ? '0' : '1';
    });
  }

  function syncRepeaterEmptyState(root) {
    const list = root.querySelector('[data-repeater-list]');
    const empty = root.querySelector('[data-repeater-empty]');
    if (!list || !empty) {
      return;
    }
    const hasRows = list.querySelectorAll('[data-repeater-row]').length > 0;
    empty.hidden = hasRows;
  }

  function bindRepeater(root) {
    if (!root || root.dataset.repeaterBound === '1') {
      return;
    }
    root.dataset.repeaterBound = '1';

    const list = root.querySelector('[data-repeater-list]');
    const template = root.querySelector('[data-repeater-template]');
    const addBtn = root.querySelector('[data-repeater-add]');
    if (!list || !template || !addBtn) {
      return;
    }

    list.querySelectorAll('[data-repeater-row]').forEach(wireTocAnchor);
    syncRepeaterEmptyState(root);

    addBtn.addEventListener('click', function () {
      const index = list.querySelectorAll('[data-repeater-row]').length;
      const html = template.innerHTML.replaceAll('__INDEX__', String(index));
      const wrap = document.createElement('div');
      wrap.innerHTML = html.trim();
      const row = wrap.firstElementChild;
      if (!row) {
        return;
      }
      list.appendChild(row);
      reindexRepeater(root);
      wireTocAnchor(row);
      syncRepeaterEmptyState(root);
      row.querySelector('input, textarea')?.focus();
    });

    root.addEventListener('click', function (event) {
      const removeBtn = event.target.closest('[data-repeater-remove]');
      if (!removeBtn || !root.contains(removeBtn)) {
        return;
      }
      const row = removeBtn.closest('[data-repeater-row]');
      if (!row) {
        return;
      }
      row.remove();
      reindexRepeater(root);
      syncRepeaterEmptyState(root);
    });
  }

  function bindRepeaters(scope = document) {
    (scope || document).querySelectorAll('[data-admin-repeater]').forEach(bindRepeater);
  }

  function openAdminModal(selector) {
    const el = typeof selector === 'string' ? document.querySelector(selector) : selector;
    if (!el) {
      return null;
    }

    el.hidden = false;
    document.body.classList.add('admin-modal-open');

    const focusable = el.querySelector('input, textarea, select, button:not([data-admin-modal-close])');
    if (focusable) {
      window.setTimeout(function () {
        focusable.focus();
      }, 30);
    }

    return el;
  }

  function closeAdminModal(selector) {
    const el = typeof selector === 'string' ? document.querySelector(selector) : selector;
    if (!el) {
      return;
    }

    el.hidden = true;
    if (!document.querySelector('.admin-modal:not([hidden])')) {
      document.body.classList.remove('admin-modal-open');
    }
  }

  function bindAdminModals(root = document) {
    $(root)
      .off('click.suaveAdminModalClose', '[data-admin-modal-close]')
      .on('click.suaveAdminModalClose', '[data-admin-modal-close]', function () {
        const modal = this.closest('.admin-modal');
        if (modal) {
          closeAdminModal(modal);
        }
      });

    $(root)
      .off('keydown.suaveAdminModalEsc')
      .on('keydown.suaveAdminModalEsc', function (event) {
        if (event.key !== 'Escape') {
          return;
        }
        const open = document.querySelector('.admin-modal:not([hidden])');
        if (open) {
          closeAdminModal(open);
        }
      });
  }

  function openGalleryPicker(options = {}) {
    const modal = document.getElementById('admin-gallery-picker');
    if (!modal) {
      createFlashMessage('error', 'Gallery picker is unavailable. Check gallery.view permission.');
      return;
    }

    const browseUrl = modal.getAttribute('data-browse-url');
    const grid = document.getElementById('admin-gallery-picker-grid');
    const empty = document.getElementById('admin-gallery-picker-empty');
    const pager = document.getElementById('admin-gallery-picker-pager');
    const pageLabel = pager ? pager.querySelector('[data-gallery-picker-page]') : null;
    const searchInput = document.getElementById('admin-gallery-picker-search');
    const prevBtn = pager ? pager.querySelector('[data-gallery-picker-prev]') : null;
    const nextBtn = pager ? pager.querySelector('[data-gallery-picker-next]') : null;

    let page = 1;
    let lastPage = 1;
    let search = '';
    let searchTimer = null;
    const onSelect = typeof options.onSelect === 'function' ? options.onSelect : null;

    function renderItems(items) {
      if (!grid) {
        return;
      }
      grid.innerHTML = '';
      items.forEach(function (item) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'admin-gallery-picker__item';
        btn.setAttribute('data-gallery-id', String(item.id));

        const img = document.createElement('img');
        img.src = item.medium_thumb_url || item.small_thumb_url || item.url || '';
        img.alt = item.alt_text || item.title || 'Gallery image';
        btn.appendChild(img);

        const label = document.createElement('span');
        label.className = 'admin-gallery-picker__item-label';
        label.textContent = item.title || item.alt_text || ('Image #' + item.id);
        btn.appendChild(label);

        btn.addEventListener('click', function () {
          if (onSelect) {
            onSelect(item);
          }
          closeAdminModal(modal);
        });

        grid.appendChild(btn);
      });
    }

    function load() {
      if (!browseUrl) {
        return;
      }

      ajax({
        url: browseUrl,
        method: 'GET',
        data: {
          _ajax: 1,
          page: page,
          search: search,
        },
      })
        .done(function (response) {
          const items = response?.data || [];
          const meta = response?.meta || {};
          lastPage = Number(meta.last_page || 1) || 1;
          page = Number(meta.current_page || page) || page;

          renderItems(items);

          if (empty) {
            empty.hidden = items.length > 0;
          }
          if (pager) {
            pager.hidden = lastPage <= 1;
          }
          if (pageLabel) {
            pageLabel.textContent = 'Page ' + page + ' of ' + lastPage;
          }
          if (prevBtn) {
            prevBtn.disabled = page <= 1;
          }
          if (nextBtn) {
            nextBtn.disabled = page >= lastPage;
          }
        })
        .fail(function (xhr) {
          toast.validation(xhr, 'Unable to load gallery images.');
        });
    }

    if (searchInput) {
      searchInput.value = '';
      searchInput.oninput = function () {
        window.clearTimeout(searchTimer);
        searchTimer = window.setTimeout(function () {
          search = (searchInput.value || '').trim();
          page = 1;
          load();
        }, 280);
      };
    }

    if (prevBtn) {
      prevBtn.onclick = function () {
        if (page > 1) {
          page -= 1;
          load();
        }
      };
    }

    if (nextBtn) {
      nextBtn.onclick = function () {
        if (page < lastPage) {
          page += 1;
          load();
        }
      };
    }

    openAdminModal(modal);
    load();
  }

  function bindGalleryFields(root = document) {
    (root || document).querySelectorAll('[data-gallery-field]').forEach(function (field) {
      if (field.dataset.galleryBound === '1') {
        return;
      }
      field.dataset.galleryBound = '1';

      const idInput = field.querySelector('[data-gallery-id-input]');
      const previewWrap = field.querySelector('[data-gallery-preview]');
      const previewImg = field.querySelector('[data-gallery-preview-img]');
      const chooseBtn = field.querySelector('[data-gallery-choose]');
      const clearBtn = field.querySelector('[data-gallery-clear]');
      const removeInput = field.querySelector('[data-gallery-remove-input]');

      function setPreview(url) {
        if (!previewWrap || !previewImg) {
          return;
        }
        if (url) {
          previewImg.src = url;
          previewWrap.hidden = false;
          if (clearBtn) {
            clearBtn.hidden = false;
          }
        } else {
          previewImg.removeAttribute('src');
          previewWrap.hidden = true;
          if (clearBtn) {
            clearBtn.hidden = true;
          }
        }
      }

      function setRemoveFlag(on) {
        if (!removeInput) {
          return;
        }
        removeInput.value = on ? '1' : '0';
        if (removeInput.type === 'checkbox') {
          removeInput.checked = !!on;
        }
      }

      if (chooseBtn) {
        chooseBtn.addEventListener('click', function () {
          openGalleryPicker({
            onSelect: function (item) {
              if (idInput) {
                idInput.value = String(item.id);
              }
              setRemoveFlag(false);
              const previewUrl =
                field.getAttribute('data-gallery-preview-size') === 'small'
                  ? item.small_thumb_url || item.url
                  : item.medium_thumb_url || item.url;
              setPreview(previewUrl || '');
            },
          });
        });
      }

      if (clearBtn) {
        clearBtn.addEventListener('click', function () {
          if (idInput) {
            idInput.value = '';
          }
          setRemoveFlag(true);
          setPreview('');
        });
      }
    });
  }

  function boot(flash = {}) {
    configureToastr();
    toast.fromFlash(flash);
    bindAjaxForms();
    bindDeleteButtons();
    bindFlatpickrs();
    bindDetailsOutsideClose();
    bindRepeaters();
    bindAdminModals();
    bindGalleryFields();
  }

  window.SuaveAdmin = {
    csrfToken,
    createFlashMessage,
    toast,
    configureToastr,
    ajax,
    submitForm,
    initDataTable,
    reloadDataTable,
    destroyRecord,
    confirmDialog,
    bindAjaxForms,
    bindDeleteButtons,
    initRichTextEditor,
    getRichTextEditor,
    syncRichTextEditors,
    initFlatpickr,
    bindFlatpickrs,
    initDateRangeFilter,
    bindRepeaters,
    openAdminModal,
    closeAdminModal,
    bindAdminModals,
    openGalleryPicker,
    bindGalleryFields,
    boot,
  };
})(window, window.jQuery);
