<div class="admin-password-field" data-password-field>
  @if ($showLabel)
    <label for="{{ $id }}" class="admin-label">{{ $label }}</label>
  @endif

  <div class="admin-password-field__control">
    <input
      id="{{ $id }}"
      type="password"
      name="{{ $name }}"
      value="{{ $value }}"
      class="{{ $inputClass }} admin-password-field__input"
      placeholder="{{ $placeholder }}"
      autocomplete="{{ $autocomplete }}"
      data-password-field-input
      @if ($required) required @endif
      {{ $attributes }}
    >

    <button
      type="button"
      class="admin-password-field__toggle"
      data-password-field-toggle
      aria-label="Show password"
      aria-pressed="false"
    >
      <i class="fa-solid fa-eye" data-password-field-icon-show aria-hidden="true"></i>
      <i class="fa-solid fa-eye-slash" data-password-field-icon-hide hidden aria-hidden="true"></i>
    </button>
  </div>
</div>

@once('admin-password-field')
  @push('scripts')
    <script>
      (function () {
        function initPasswordField(root) {
          if (!root || root.dataset.passwordFieldReady === '1') return;
          root.dataset.passwordFieldReady = '1';

          var input = root.querySelector('[data-password-field-input]');
          var toggle = root.querySelector('[data-password-field-toggle]');
          var iconShow = root.querySelector('[data-password-field-icon-show]');
          var iconHide = root.querySelector('[data-password-field-icon-hide]');
          if (!input || !toggle) return;

          toggle.addEventListener('click', function () {
            var revealing = input.type === 'password';
            input.type = revealing ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', revealing ? 'true' : 'false');
            toggle.setAttribute('aria-label', revealing ? 'Hide password' : 'Show password');
            if (iconShow) iconShow.hidden = revealing;
            if (iconHide) iconHide.hidden = !revealing;
          });
        }

        function initAll(scope) {
          (scope || document).querySelectorAll('[data-password-field]').forEach(initPasswordField);
        }

        window.SuavePasswordField = { initAll: initAll };

        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', function () { initAll(document); });
        } else {
          initAll(document);
        }
      })();
    </script>
  @endpush
@endonce
