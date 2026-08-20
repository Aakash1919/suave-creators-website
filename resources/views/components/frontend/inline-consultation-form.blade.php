@props([
    'theme' => 'dark',
    'placeholder' => 'Enter your phone or email',
    'buttonText' => 'Get Free Consultation',
    'secondaryHref' => '',
    'secondaryLabel' => '',
    'formId' => null,
])

@php
    $resolvedFormId = $formId ?? ('consultation-inline-form-'.\Illuminate\Support\Str::random(6));
    $isDark = $theme === 'dark';
@endphp

<div class="consultation-inline-wrapper">
  <form id="{{ $resolvedFormId }}" action="{{ route('consultation.store') }}" method="POST"
    class="consultation-inline-form consultation-inline-form--{{ $theme }}"
    data-consultation-form
    data-draft-url="{{ route('contact-us.draft') }}"
    novalidate>
    @csrf
    <input type="hidden" name="draft_token" value="" data-consultation-draft-token>
    <input type="hidden" name="form_started_at" value="{{ time() }}">
    <div style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;" aria-hidden="true">
      <input type="text" name="website" tabindex="-1" autocomplete="off">
    </div>

    {{-- Input --}}
    <input type="text" name="contact" required
      placeholder="{{ $placeholder }}"
      class="consultation-inline-form__input"
      aria-label="{{ $placeholder }}">

    {{-- Divider --}}
    <span class="consultation-inline-form__divider" aria-hidden="true"></span>

    {{-- Button --}}
    <button type="submit" class="consultation-inline-form__btn">
      <span data-button-label>{{ $buttonText }}</span>
      <x-frontend.cta-arrow />
    </button>
  </form>

  <div class="consultation-inline-status mt-2 text-xs font-medium px-1 text-left" hidden></div>

  @if ($secondaryLabel !== '' && $secondaryHref !== '' && true == false)
    <div class="mt-3 flex items-center">
      <a href="{{ $secondaryHref }}" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center border-b {{ $isDark ? 'border-white/70 text-white/80 hover:text-white' : 'border-[#00003F] text-[#00003F] hover:text-[#2A4DFB]' }} text-[13px] sm:text-sm font-semibold transition">
        {{ $secondaryLabel }}
      </a>
    </div>
  @endif
</div>

@once
@push('scripts')
<script>
  (function () {
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    var DRAFT_SAVE_DELAY_MS = 900;
    var DRAFT_STORAGE_PREFIX = 'suave_consultation_draft_v1:';

    function initConsultationForm(form) {
      if (form.dataset.consultationInitialized) return;
      form.dataset.consultationInitialized = 'true';

      var wrapper = form.closest('.consultation-inline-wrapper');
      var statusEl = wrapper ? wrapper.querySelector('.consultation-inline-status') : null;
      var input = form.querySelector('input[name="contact"]');
      var submitBtn = form.querySelector('button[type="submit"]');
      var labelSpan = submitBtn ? submitBtn.querySelector('[data-button-label]') : null;
      var originalBtnText = labelSpan ? labelSpan.textContent : (submitBtn ? submitBtn.textContent : '');
      var draftUrl = form.getAttribute('data-draft-url') || '';
      var draftTokenInput = form.querySelector('[data-consultation-draft-token]');
      var draftStorageKey = DRAFT_STORAGE_PREFIX + (form.id || 'default');
      var draftTimer = null;
      var draftAbort = null;
      var lastDraftPayload = '';
      var submitted = false;

      function showMessage(type, message) {
        if (!statusEl) return;
        statusEl.hidden = false;
        statusEl.textContent = message;
        if (type === 'success') {
          statusEl.className = 'consultation-inline-status consultation-inline-status--success mt-2 text-xs font-semibold px-1 text-emerald-400';
          form.classList.remove('has-error');
        } else {
          statusEl.className = 'consultation-inline-status consultation-inline-status--error mt-2 text-xs font-semibold px-1 text-red-500';
          form.classList.add('has-error');
        }
      }

      function clearMessage() {
        if (!statusEl) return;
        statusEl.hidden = true;
        statusEl.textContent = '';
        form.classList.remove('has-error');
      }

      function createDraftToken() {
        if (window.crypto && typeof window.crypto.randomUUID === 'function') {
          return window.crypto.randomUUID();
        }

        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (char) {
          var rand = Math.random() * 16 | 0;
          var value = char === 'x' ? rand : (rand & 0x3 | 0x8);

          return value.toString(16);
        });
      }

      function readStoredDraftToken() {
        try {
          return sessionStorage.getItem(draftStorageKey) || '';
        } catch (error) {
          return '';
        }
      }

      function writeStoredDraftToken(token) {
        try {
          if (token) {
            sessionStorage.setItem(draftStorageKey, token);
          } else {
            sessionStorage.removeItem(draftStorageKey);
          }
        } catch (error) {
          // Private mode may block sessionStorage.
        }
      }

      function setDraftToken(token) {
        if (draftTokenInput) {
          draftTokenInput.value = token || '';
        }
        writeStoredDraftToken(token || '');
      }

      function ensureDraftToken() {
        var existing = ((draftTokenInput && draftTokenInput.value) || '').trim() || readStoredDraftToken();
        var token = existing || createDraftToken();
        setDraftToken(token);

        return token;
      }

      function draftPayload(value) {
        var data = {
          name: '',
          email: '',
          phone: '',
          service: '',
          message: '',
        };

        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
          data.email = value;
        } else {
          data.phone = value;
        }

        data.message = 'Inline consultation started for: ' + value;

        return data;
      }

      function saveDraft(keepalive) {
        if (submitted || !draftUrl || !input) return;

        var value = input.value.trim();
        if (!value) return;

        var data = draftPayload(value);
        var serialized = JSON.stringify(data);
        if (serialized === lastDraftPayload) return;

        var body = new FormData();
        body.append('draft_token', ensureDraftToken());
        body.append('name', data.name);
        body.append('email', data.email);
        body.append('phone', data.phone);
        body.append('service', data.service);
        body.append('message', data.message);

        if (draftAbort) {
          draftAbort.abort();
        }
        draftAbort = new AbortController();

        fetch(draftUrl, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrf,
          },
          body: body,
          credentials: 'same-origin',
          keepalive: !!keepalive,
          signal: keepalive ? undefined : draftAbort.signal,
        })
          .then(async function (response) {
            var data = await response.json().catch(function () { return {}; });
            if (!response.ok || data.success === false) return;
            if (data.draft_token) {
              setDraftToken(data.draft_token);
            }
            lastDraftPayload = serialized;
          })
          .catch(function () {
            // Draft capture is best-effort; submit still works without it.
          });
      }

      function scheduleDraftSave() {
        if (draftTimer) {
          window.clearTimeout(draftTimer);
        }

        draftTimer = window.setTimeout(function () {
          draftTimer = null;
          saveDraft(false);
        }, DRAFT_SAVE_DELAY_MS);
      }

      function flushDraftSave(keepalive) {
        if (draftTimer) {
          window.clearTimeout(draftTimer);
          draftTimer = null;
        }

        saveDraft(keepalive);
      }

      var storedToken = readStoredDraftToken();
      if (storedToken) {
        setDraftToken(storedToken);
      }

      if (input) {
        input.addEventListener('input', function () {
          clearMessage();
          scheduleDraftSave();
        });
        input.addEventListener('change', function () {
          flushDraftSave(false);
        });
        input.addEventListener('blur', function () {
          flushDraftSave(false);
        });
      }

      window.addEventListener('pagehide', function () {
        flushDraftSave(true);
      });

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearMessage();

        var value = (input ? input.value : '').trim();
        if (!value) {
          showMessage('error', 'Please enter your phone number or email address.');
          if (input) input.focus();
          return;
        }

        var isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        var isPhone = /^[+]?[\d\s().\-\/]{7,25}$/.test(value);

        if (!isEmail && !isPhone) {
          showMessage('error', 'Please enter a valid phone number or email address.');
          if (input) input.focus();
          return;
        }

        if (submitBtn) {
          var currentBtnWidth = submitBtn.getBoundingClientRect().width;
          if (currentBtnWidth > 0) {
            submitBtn.style.minWidth = currentBtnWidth + 'px';
          }
          submitBtn.disabled = true;
        }
        if (labelSpan) labelSpan.textContent = 'Submitting…';
        submitted = true;
        if (draftTimer) {
          window.clearTimeout(draftTimer);
          draftTimer = null;
        }
        if (draftAbort) {
          draftAbort.abort();
        }

        fetch(form.action, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrf,
          },
          body: new FormData(form),
          credentials: 'same-origin',
        })
          .then(async function (response) {
            var data = await response.json().catch(function () { return {}; });

            if (response.status === 422) {
              var err = (data.errors && data.errors.contact && data.errors.contact[0]) || data.message || 'Please check your input and try again.';
              submitted = false;
              showMessage('error', err);
              return;
            }

            if (!response.ok || data.success === false) {
              submitted = false;
              showMessage('error', data.message || 'Unable to submit request. Please try again.');
              return;
            }

            if (typeof window.suaveTrackEvent === 'function') {
              window.suaveTrackEvent('generate_lead', {
                lead_type: 'consultation_inline',
                form_name: 'inline_consultation_form',
                contact_type: isEmail ? 'email' : 'phone',
              });
            }

            clearMessage();
            setDraftToken('');
            lastDraftPayload = '';
            if (input) input.value = '';

            // Start Suave Agent chat session with the entered contact details
            if (data.chat_session) {
              if (window.SuaveAgent && typeof window.SuaveAgent.startWithSession === 'function') {
                window.SuaveAgent.startWithSession(data.chat_session);
              } else {
                window.dispatchEvent(new CustomEvent('suave-agent:start', { detail: { chat_session: data.chat_session } }));
              }
            } else {
              if (window.SuaveAgent && typeof window.SuaveAgent.startWithContact === 'function') {
                window.SuaveAgent.startWithContact(value);
              } else {
                window.dispatchEvent(new CustomEvent('suave-agent:start', { detail: { contact: value } }));
              }
            }
          })
          .catch(function () {
            submitted = false;
            showMessage('error', 'Unable to submit request. Please try again.');
          })
          .finally(function () {
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.style.minWidth = '';
            }
            if (labelSpan) labelSpan.textContent = originalBtnText;
          });
      });
    }

    document.querySelectorAll('form[data-consultation-form]').forEach(initConsultationForm);
  })();
</script>
@endpush
@endonce
