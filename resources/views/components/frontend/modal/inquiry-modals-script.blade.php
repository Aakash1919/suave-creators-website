@once('frontend-modal-inquiry-modals-script')
  @push('scripts')
  <script>
    (function () {
      var dialogs = document.querySelectorAll('[data-inquiry-dialog]');
      if (!dialogs.length || dialogs[0].dataset.enquiryInitialized) return;
      dialogs[0].dataset.enquiryInitialized = 'true';

      var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
      var openDialog = null;
      var lastTrigger = null;
      var estimateDialog = document.querySelector('[data-inquiry-kind="project-estimate"]');
      var hireDialog = document.querySelector('[data-inquiry-kind="hire-developers"]');
      var requiredMessages = {
        name: 'Please enter your name.',
        email: 'Please enter your work email.',
        service: 'Please select an option.',
        message: 'Please tell us about your request.',
        company: 'Please enter your company name.',
        expertise: 'Please select the expertise you need.',
        support_type: 'Please select the kind of support you need.',
        budget: 'Please select a budget range.',
        start_when: 'Please select when you need to start.'
      };

      function focusable(dialog) {
        return Array.prototype.filter.call(dialog.querySelectorAll('button, a[href], input, select, textarea'), function (el) {
          return !el.disabled && el.tabIndex !== -1 && !el.closest('.inquiry-modal__honeypot') && el.type !== 'hidden';
        });
      }

      function inquirySelectRoot(form, name) {
        return form ? form.querySelector('[data-inquiry-select-name="' + name + '"]') : null;
      }

      function setInquirySelectValue(root, value, silent) {
        if (!root) return false;
        var input = root.querySelector('[data-inquiry-select-value]');
        var label = root.querySelector('[data-inquiry-select-label]');
        var icon = root.querySelector('[data-inquiry-select-icon]');
        var placeholder = root.getAttribute('data-placeholder') || 'Select an option';
        var defaultIcon = root.getAttribute('data-default-icon') || 'fa-solid fa-shapes';
        var defaultColor = root.getAttribute('data-default-color') || '#64748B';
        var option = value
          ? root.querySelector('[data-inquiry-select-option][data-value="' + CSS.escape(value) + '"]')
          : null;

        root.querySelectorAll('[data-inquiry-select-option]').forEach(function (opt) {
          opt.classList.toggle('is-active', !!(option && opt === option));
        });

        if (!option) {
          if (input) input.value = '';
          if (label) {
            label.textContent = placeholder;
            label.classList.add('inquiry-select__label--placeholder');
          }
          if (icon) {
            icon.innerHTML = '<i class="' + defaultIcon + '" style="color: ' + defaultColor + ';"></i>';
          }
          if (!silent) {
            input && input.dispatchEvent(new Event('change', { bubbles: true }));
          }
          return false;
        }

        var optLabel = option.getAttribute('data-label') || '';
        var optIcon = option.getAttribute('data-icon') || defaultIcon;
        var optColor = option.getAttribute('data-color') || defaultColor;
        if (input) input.value = option.getAttribute('data-value') || '';
        if (label) {
          label.textContent = optLabel;
          label.classList.remove('inquiry-select__label--placeholder');
        }
        if (icon) {
          icon.innerHTML = '<i class="' + optIcon + '" style="color: ' + optColor + ';"></i>';
        }
        if (!silent) {
          input && input.dispatchEvent(new Event('change', { bubbles: true }));
        }
        return true;
      }

      function resetInquirySelects(form) {
        form.querySelectorAll('[data-inquiry-select]').forEach(function (root) {
          setInquirySelectValue(root, '', true);
          root.classList.remove('is-invalid');
          closeInquirySelect(root);
        });
      }

      function closeInquirySelect(root) {
        if (!root) return;
        var menu = root.querySelector('[data-inquiry-select-menu]');
        var trigger = root.querySelector('[data-inquiry-select-trigger]');
        if (menu) menu.hidden = true;
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
      }

      function closeAllInquirySelects(except) {
        document.querySelectorAll('[data-inquiry-select]').forEach(function (root) {
          if (except && root === except) return;
          closeInquirySelect(root);
        });
      }

      function toggleInquirySelect(root, open) {
        if (!root) return;
        var menu = root.querySelector('[data-inquiry-select-menu]');
        var trigger = root.querySelector('[data-inquiry-select-trigger]');
        if (!menu || !trigger) return;
        var shouldOpen = open !== undefined ? open : menu.hidden;
        if (shouldOpen) {
          closeAllInquirySelects(root);
          menu.hidden = false;
          trigger.setAttribute('aria-expanded', 'true');
        } else {
          closeInquirySelect(root);
        }
      }

      document.querySelectorAll('[data-inquiry-select]').forEach(function (root) {
        var trigger = root.querySelector('[data-inquiry-select-trigger]');
        if (trigger) {
          trigger.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            toggleInquirySelect(root);
          });
        }
        root.querySelectorAll('[data-inquiry-select-option]').forEach(function (option) {
          option.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            setInquirySelectValue(root, option.getAttribute('data-value') || '');
            root.classList.remove('is-invalid');
            closeInquirySelect(root);
          });
        });
      });

      document.addEventListener('click', function (event) {
        if (event.target.closest('[data-inquiry-select]')) return;
        closeAllInquirySelects();
      });

      function consultationContactFromTrigger(trigger) {
        var forms = [];
        if (trigger) {
          var nearest = trigger.closest('form[data-consultation-form]');
          if (nearest) forms.push(nearest);
        }
        document.querySelectorAll('form[data-consultation-form]').forEach(function (form) {
          if (forms.indexOf(form) === -1) forms.push(form);
        });
        for (var i = 0; i < forms.length; i++) {
          var input = forms[i].querySelector('input[name="contact"]');
          var value = input ? String(input.value || '').trim() : '';
          if (value) return value;
        }
        return '';
      }

      function prefillInquiryFromContact(dialog, contact) {
        if (!dialog || !contact) return;
        var form = dialog.querySelector('[data-inquiry-form]');
        if (!form) return;
        var emailField = form.querySelector('input[name="email"]');
        if (!emailField) return;
        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(contact)) {
          emailField.value = contact;
          emailField.dispatchEvent(new Event('input', { bubbles: true }));
          clearFieldError(form, 'email');
        }
      }

      function openInquiryDialog(id, trigger) {
        var dialog = typeof id === 'string' ? document.getElementById(id) : id;
        if (!dialog) return;
        if (openDialog && openDialog !== dialog) {
          openDialog.hidden = true;
        }
        dialog.hidden = false;
        document.body.style.overflow = 'hidden';
        openDialog = dialog;
        lastTrigger = trigger || null;
        closeAllInquirySelects();
        prefillInquiryFromContact(dialog, consultationContactFromTrigger(trigger));
        var field = dialog.querySelector('input[name="name"]');
        if (field) field.focus();
      }

      function closeInquiryDialog(dialog) {
        if (!dialog) return;
        dialog.hidden = true;
        closeAllInquirySelects();
        if (openDialog === dialog) {
          openDialog = null;
          document.body.style.overflow = '';
        }
        if (lastTrigger) {
          lastTrigger.focus();
          lastTrigger = null;
        }
      }

      document.querySelectorAll('[data-inquiry-dialog-open]').forEach(function (button) {
        button.addEventListener('click', function () {
          openInquiryDialog(button.getAttribute('data-inquiry-dialog-open'), button);
        });
      });

      document.addEventListener('click', function (event) {
        var modalLink = event.target.closest('a[href="#project-estimate-dialog"], a[href="#hire-developers-dialog"]');
        if (modalLink && !modalLink.closest('[data-inquiry-dialog]')) {
          var dialogId = (modalLink.getAttribute('href') || '').slice(1);
          var linkedDialog = document.getElementById(dialogId);
          if (linkedDialog && linkedDialog.hasAttribute('data-inquiry-dialog')) {
            event.preventDefault();
            event.stopPropagation();
            openInquiryDialog(linkedDialog, modalLink);
            return;
          }
        }

        var trigger = event.target.closest('[data-open-contact-modal], a[href="#contact-modal"]');
        if (!trigger || trigger.closest('[data-inquiry-dialog]')) return;
        if (!estimateDialog && !hireDialog) return;
        var service = trigger.getAttribute('data-service') || 'custom-software';
        var hire = service === 'hire-developers';
        var target = hire ? hireDialog : estimateDialog;
        if (!target) return;
        event.preventDefault();
        event.stopPropagation();
        openInquiryDialog(target, trigger);
        if (!hire && estimateDialog) {
          var serviceRoot = inquirySelectRoot(estimateDialog.querySelector('[data-inquiry-form]'), 'service');
          setInquirySelectValue(serviceRoot, service, true);
        }
      }, true);

      dialogs.forEach(function (dialog) {
        dialog.querySelectorAll('[data-inquiry-dialog-close]').forEach(function (button) {
          button.addEventListener('click', function () {
            closeInquiryDialog(dialog);
          });
        });
      });

      document.addEventListener('keydown', function (event) {
        if (!openDialog) return;
        if (event.key === 'Escape') {
          event.preventDefault();
          var openSelect = openDialog.querySelector('[data-inquiry-select-trigger][aria-expanded="true"]');
          if (openSelect) {
            closeAllInquirySelects();
            return;
          }
          closeInquiryDialog(openDialog);
          return;
        }
        if (event.key !== 'Tab') return;
        var items = focusable(openDialog);
        if (!items.length) return;
        var first = items[0];
        var last = items[items.length - 1];
        if (event.shiftKey && document.activeElement === first) {
          event.preventDefault();
          last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
          event.preventDefault();
          first.focus();
        }
      });

      function clearErrors(form) {
        form.querySelectorAll('[data-error-for]').forEach(function (slot) {
          slot.hidden = true;
          slot.textContent = '';
        });
        form.querySelectorAll('.is-invalid').forEach(function (field) {
          field.classList.remove('is-invalid');
          field.removeAttribute('aria-invalid');
        });
      }

      function showFieldError(form, name, message) {
        var field = form.elements[name];
        var slot = form.querySelector('[data-error-for="' + name + '"]');
        var selectRoot = inquirySelectRoot(form, name);
        if (selectRoot) {
          selectRoot.classList.add('is-invalid');
          var trigger = selectRoot.querySelector('[data-inquiry-select-trigger]');
          if (trigger) trigger.setAttribute('aria-invalid', 'true');
        } else if (field && field.classList) {
          field.classList.add('is-invalid');
          field.setAttribute('aria-invalid', 'true');
        }
        if (slot) {
          slot.hidden = false;
          slot.textContent = message;
        }
      }

      function clearFieldError(form, name) {
        var field = form.elements[name];
        var slot = form.querySelector('[data-error-for="' + name + '"]');
        var selectRoot = inquirySelectRoot(form, name);
        if (selectRoot) {
          selectRoot.classList.remove('is-invalid');
          var trigger = selectRoot.querySelector('[data-inquiry-select-trigger]');
          if (trigger) trigger.removeAttribute('aria-invalid');
        }
        if (field && field.classList) {
          field.classList.remove('is-invalid');
          field.removeAttribute('aria-invalid');
        }
        if (slot) {
          slot.hidden = true;
          slot.textContent = '';
        }
      }

      function optionAllowed(root, value) {
        return !!root.querySelector('[data-inquiry-select-option][data-value="' + CSS.escape(value) + '"]');
      }

      function fieldMessage(field) {
        if (!field || !field.name || field.closest('.inquiry-modal__honeypot')) return '';
        var isInquirySelect = field.hasAttribute('data-inquiry-select-value');
        if (field.type === 'hidden' && !isInquirySelect) return '';
        var value = String(field.value || '').trim();
        var max = field.maxLength > 0 ? field.maxLength : 0;
        if ((field.required || isInquirySelect) && value === '') {
          return requiredMessages[field.name] || 'Please complete this field.';
        }
        if (value === '') return '';
        if (max && value.length > max) {
          return 'Please use ' + max + ' characters or fewer.';
        }
        if (field.name === 'name' && value.length < 2) {
          return 'Please enter your full name.';
        }
        if (field.name === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
          return 'Please enter a valid email address.';
        }
        if (field.name === 'company' && value.length < 2) {
          return 'Please enter your company name.';
        }
        if (field.name === 'message' && value.length < 10) {
          return 'Please write at least 10 characters about your request.';
        }
        if (isInquirySelect) {
          var root = field.closest('[data-inquiry-select]');
          if (root && !optionAllowed(root, value)) {
            if (field.name === 'budget') return 'Please select a valid budget range.';
            if (field.name === 'start_when') return 'Please select a valid start time.';
            if (field.name === 'expertise') return 'Please select a valid expertise.';
            if (field.name === 'support_type') return 'Please select a valid support type.';
            if (field.name === 'service') return 'Please select a valid option.';
            return 'Please select a valid option.';
          }
        }
        return '';
      }

      function clientErrors(form) {
        var errors = {};
        form.querySelectorAll('.inquiry-modal__field input, .inquiry-modal__field textarea').forEach(function (field) {
          var message = fieldMessage(field);
          if (message) errors[field.name] = [message];
        });
        return errors;
      }

      function applyErrors(form, errors) {
        clearErrors(form);
        var statusEl = form.querySelector('[data-inquiry-status]');
        var unmatched = [];
        Object.keys(errors).forEach(function (name) {
          var message = errors[name][0];
          if (form.querySelector('[data-error-for="' + name + '"]')) {
            showFieldError(form, name, message);
          } else {
            unmatched.push(message);
          }
        });
        if (statusEl) {
          statusEl.classList.toggle('is-error', unmatched.length > 0);
          statusEl.hidden = unmatched.length === 0;
          statusEl.textContent = unmatched[0] || '';
        }
        var firstInvalid = form.querySelector('.inquiry-select.is-invalid [data-inquiry-select-trigger], .is-invalid');
        if (firstInvalid) firstInvalid.focus();
      }

      document.querySelectorAll('[data-inquiry-form]').forEach(function (form) {
        var tokenInput = form.querySelector('[data-inquiry-draft-token]');
        var statusEl = form.querySelector('[data-inquiry-status]');
        var draftTimer = null;
        var isSubmitting = false;

        function scheduleDraft() {
          window.clearTimeout(draftTimer);
          draftTimer = window.setTimeout(saveDraft, 900);
        }

        function saveDraft() {
          var body = new FormData(form);
          var name = String(body.get('name') || '').trim();
          var email = String(body.get('email') || '').trim();
          if (name === '' && email === '') return;

          fetch(form.getAttribute('data-draft-url'), {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': csrf
            },
            body: body,
            credentials: 'same-origin'
          }).then(function (response) {
            return response.json();
          }).then(function (data) {
            if (data && data.draft_token && tokenInput) {
              tokenInput.value = data.draft_token;
            }
          }).catch(function () {});
        }

        form.querySelectorAll('.inquiry-modal__field input, .inquiry-modal__field textarea').forEach(function (input) {
          function refreshShownError() {
            var selectRoot = input.hasAttribute('data-inquiry-select-value')
              ? input.closest('[data-inquiry-select]')
              : null;
            var showing = (selectRoot && selectRoot.classList.contains('is-invalid')) || input.classList.contains('is-invalid');
            if (!showing) return;
            var message = fieldMessage(input);
            if (message) showFieldError(form, input.name, message);
            else clearFieldError(form, input.name);
          }
          input.addEventListener('change', function () {
            refreshShownError();
            scheduleDraft();
          });
          input.addEventListener('blur', function () {
            scheduleDraft();
          });
          input.addEventListener('input', refreshShownError);
        });

        form.addEventListener('submit', function (event) {
          event.preventDefault();
          if (isSubmitting) return;
          var errors = clientErrors(form);
          if (Object.keys(errors).length) {
            applyErrors(form, errors);
            return;
          }
          clearErrors(form);
          isSubmitting = true;
          var submitBtn = form.querySelector('[type="submit"]');
          if (submitBtn) submitBtn.disabled = true;

          fetch(form.action, {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': csrf
            },
            body: new FormData(form),
            credentials: 'same-origin'
          }).then(async function (response) {
            var data = await response.json().catch(function () { return {}; });
            if (submitBtn) submitBtn.disabled = false;
            if (response.status === 422) {
              applyErrors(form, data.errors || {});
              if (statusEl && !form.querySelector('.is-invalid')) {
                statusEl.hidden = false;
                statusEl.classList.add('is-error');
                statusEl.textContent = data.message || 'Please check the form and try again.';
              }
              return;
            }
            if (!statusEl) return;
            statusEl.hidden = false;
            statusEl.classList.toggle('is-error', !response.ok || data.success !== true);
            if (!response.ok || data.success !== true) {
              statusEl.textContent = data.message || 'Unable to submit request. Please try again.';
              return;
            }
            if (data.lead_tracked === true && typeof window.suaveTrackEvent === 'function') {
              var formName = form.closest('[data-inquiry-kind]').dataset.inquiryKind === 'hire-developers'
                ? 'hire_developers' : 'project_estimate';
              window.suaveTrackEvent('generate_lead', {
                lead_type: 'enquiry_form',
                form_name: formName,
              });
            }
            statusEl.textContent = data.message || 'The request has been sent successfully.';
            form.reset();
            resetInquirySelects(form);
            if (tokenInput) tokenInput.value = '';
          }).catch(function () {
            if (submitBtn) submitBtn.disabled = false;
            if (!statusEl) return;
            statusEl.hidden = false;
            statusEl.classList.add('is-error');
            statusEl.textContent = 'Unable to submit request. Please try again.';
          }).finally(function () {
            isSubmitting = false;
            if (submitBtn) submitBtn.disabled = false;
          });
        });
      });

      window.SuaveInquiryModals = {
        open: openInquiryDialog,
        close: closeInquiryDialog,
        resetSelects: resetInquirySelects,
        setSelect: function (formOrDialog, name, value) {
          var form = formOrDialog.matches && formOrDialog.matches('[data-inquiry-form]')
            ? formOrDialog
            : formOrDialog.querySelector('[data-inquiry-form]');
          return setInquirySelectValue(inquirySelectRoot(form, name), value);
        }
      };
    })();
  </script>
  @endpush
@endonce
