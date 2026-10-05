@push('fixed-widgets')
  <div
    id="{{ $dialogId }}"
    class="inquiry-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $dialogId }}-title"
    hidden
    data-inquiry-dialog
    data-inquiry-kind="project-estimate"
  >
    <button type="button" class="inquiry-modal__backdrop" data-inquiry-dialog-close aria-label="Close project estimate dialog"></button>
    <div class="inquiry-modal__card">
      <button type="button" class="inquiry-modal__close" data-inquiry-dialog-close aria-label="Close">
        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5 5l10 10M15 5 5 15" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
      </button>
      <div class="inquiry-modal__body">
        <div class="inquiry-modal__head">
          <div class="inquiry-modal__icon" aria-hidden="true">
            <img src="{{ asset('assets/product/document.png') }}" alt="Project estimate document icon for custom software quotes at Suave Creators" title="Project estimate document icon for custom software quotes at Suave Creators" width="20" height="18" decoding="async" loading="lazy">
          </div>
          <div>
            <h3 id="{{ $dialogId }}-title">Get a Project Estimate</h3>
            <p>Share a few project details for an initial scope, timeline, and cost.</p>
          </div>
        </div>
        <form id="{{ $formId }}" class="inquiry-modal__form" action="{{ route('contact-us.store') }}" method="POST" data-inquiry-form data-draft-url="{{ route('contact-us.draft') }}" novalidate>
          @csrf
          <input type="hidden" name="draft_token" value="" data-inquiry-draft-token>
          <input type="hidden" name="form_started_at" value="{{ time() }}">
          <input type="hidden" name="inquiry" value="project-estimate">
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
              <span id="{{ $dialogId }}-service-label">What do you need an estimate for? <abbr title="required">*</abbr></span>
              <x-frontend.modal.inquiry-select
                name="service"
                :label-id="$dialogId.'-service-label'"
                placeholder="Select an option"
                :options="$serviceOptions"
                default-icon="fa-solid fa-shapes"
                default-color="#2A4DFB"
              />
              <small data-error-for="service" hidden></small>
            </div>
          </div>
          <label class="inquiry-modal__field">
            <span>Tell us about your project <abbr title="required">*</abbr></span>
            <textarea name="message" rows="3" maxlength="5000" required placeholder="Briefly describe what you want to build, the problem you're solving, or the key features you need."></textarea>
            <small data-error-for="message" hidden></small>
          </label>
          <div class="inquiry-modal__field">
            <span id="{{ $dialogId }}-budget-label">Estimated Budget <abbr title="required">*</abbr></span>
            <x-frontend.modal.inquiry-select
              name="budget"
              :label-id="$dialogId.'-budget-label'"
              placeholder="Select budget range"
              :options="$budgetOptions"
              default-icon="fa-solid fa-building"
              default-color="#2A4DFB"
            />
            <small data-error-for="budget" hidden></small>
          </div>
          <p class="inquiry-modal__status" data-inquiry-status hidden></p>
          <button type="submit" class="inquiry-modal__submit">
            Get My Estimate
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M11 5.5 15.5 10 11 14.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <p class="inquiry-modal__fine">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="6" y="11" width="12" height="8.5" rx="1.6" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M8.5 11V8.6a3.5 3.5 0 0 1 7 0V11" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            Your information is confidential. NDA available on request.
          </p>
        </form>
      </div>
    </div>
  </div>
@endpush

@include('components.frontend.modal.inquiry-modals-script')
