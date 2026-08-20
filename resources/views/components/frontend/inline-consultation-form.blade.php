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
    novalidate>
    @csrf
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

    function initConsultationForm(form) {
      if (form.dataset.consultationInitialized) return;
      form.dataset.consultationInitialized = 'true';

      var wrapper = form.closest('.consultation-inline-wrapper');
      var statusEl = wrapper ? wrapper.querySelector('.consultation-inline-status') : null;
      var input = form.querySelector('input[name="contact"]');
      var submitBtn = form.querySelector('button[type="submit"]');
      var labelSpan = submitBtn ? submitBtn.querySelector('[data-button-label]') : null;
      var originalBtnText = labelSpan ? labelSpan.textContent : (submitBtn ? submitBtn.textContent : '');

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

      if (input) input.addEventListener('input', clearMessage);

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
              showMessage('error', err);
              return;
            }

            if (!response.ok || data.success === false) {
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
