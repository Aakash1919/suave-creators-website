@push('fixed-widgets')
  <div
    id="{{ $dialogId }}"
    class="inquiry-modal inquiry-modal--hire"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $dialogId }}-title"
    hidden
    data-inquiry-dialog
    data-inquiry-kind="hire-developers"
  >
    <button type="button" class="inquiry-modal__backdrop" data-inquiry-dialog-close aria-label="Close hire developers dialog"></button>
    <div class="inquiry-modal__card">
      <button type="button" class="inquiry-modal__close" data-inquiry-dialog-close aria-label="Close">
        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5 5l10 10M15 5 5 15" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
      </button>
      <div class="inquiry-modal__body">
        <div class="inquiry-modal__head">
          <div class="inquiry-modal__icon" aria-hidden="true">
            <img src="{{ asset('assets/team/teamwork-icon.svg') }}" alt="Teamwork icon for hiring dedicated software developers at Suave Creators" title="Teamwork icon for hiring dedicated software developers at Suave Creators" width="18" height="14" decoding="async" loading="lazy">
          </div>
          <div>
            <h3 id="{{ $dialogId }}-title">Hire the Right Developers</h3>
            <p>Tell us the skills you need and we'll suggest developer options.</p>
          </div>
        </div>
        <form id="{{ $formId }}" class="inquiry-modal__form" action="{{ route('contact-us.store') }}" method="POST" data-inquiry-form data-draft-url="{{ route('contact-us.draft') }}" novalidate>
          @csrf
          <input type="hidden" name="draft_token" value="" data-inquiry-draft-token>
          <input type="hidden" name="form_started_at" value="{{ time() }}">
          <input type="hidden" name="inquiry" value="hire-developers">
          <input type="hidden" name="service" value="hire-developers">
          <div class="inquiry-modal__honeypot" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
          </div>
          <div class="inquiry-modal__row">
            <label class="inquiry-modal__field">
              <span>Name <abbr title="required">*</abbr></span>
              <input type="text" name="name" autocomplete="name" maxlength="120" placeholder="Enter your name" required>
              <small data-error-for="name" hidden></small>
            </label>
            <label class="inquiry-modal__field">
              <span>Work Email <abbr title="required">*</abbr></span>
              <input type="email" name="email" autocomplete="email" maxlength="255" placeholder="you@company.com" required>
              <small data-error-for="email" hidden></small>
            </label>
          </div>
          <div class="inquiry-modal__row">
            <label class="inquiry-modal__field">
              <span>Company <abbr title="required">*</abbr></span>
              <input type="text" name="company" autocomplete="organization" maxlength="120" placeholder="Company name" required>
              <small data-error-for="company" hidden></small>
            </label>
            <div class="inquiry-modal__field">
              <span id="{{ $dialogId }}-expertise-label">What expertise do you need? <abbr title="required">*</abbr></span>
              <x-frontend.modal.inquiry-select
                name="expertise"
                :label-id="$dialogId.'-expertise-label'"
                placeholder="Select skills"
                :options="$expertiseOptions"
                default-icon="fa-solid fa-shapes"
                default-color="#7A5FF8"
              />
              <small data-error-for="expertise" hidden></small>
            </div>
          </div>
          <div class="inquiry-modal__row">
            <div class="inquiry-modal__field">
              <span id="{{ $dialogId }}-support-label">What kind of support do you need? <abbr title="required">*</abbr></span>
              <x-frontend.modal.inquiry-select
                name="support_type"
                :label-id="$dialogId.'-support-label'"
                placeholder="Select an option"
                :options="$supportOptions"
                default-icon="fa-solid fa-user-group"
                default-color="#7A5FF8"
              />
              <small data-error-for="support_type" hidden></small>
            </div>
            <div class="inquiry-modal__field">
              <span id="{{ $dialogId }}-start-label">When do you need to start? <abbr title="required">*</abbr></span>
              <x-frontend.modal.inquiry-select
                name="start_when"
                :label-id="$dialogId.'-start-label'"
                placeholder="Select an option"
                :options="$startOptions"
                default-icon="fa-solid fa-clock"
                default-color="#7A5FF8"
              />
              <small data-error-for="start_when" hidden></small>
            </div>
          </div>
          <label class="inquiry-modal__field">
            <span>Tell us about your requirement <abbr title="required">*</abbr></span>
            <textarea name="message" rows="3" maxlength="5000" required placeholder="Tell us about the project, required skills, responsibilities, or technical requirements."></textarea>
            <small data-error-for="message" hidden></small>
          </label>
          <p class="inquiry-modal__status" data-inquiry-status hidden></p>
          <button type="submit" class="inquiry-modal__submit">
            Request Developer Options
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M11 5.5 15.5 10 11 14.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <p class="inquiry-modal__fine">NDA available on request · Flexible engagement models · Response within 1 business day.</p>
        </form>
      </div>
    </div>
  </div>
@endpush

@include('components.frontend.modal.inquiry-modals-script')
