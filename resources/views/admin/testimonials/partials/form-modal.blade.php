@php
  /** @var array{quote: string, name: string, role: string, sort_order: int, is_published: bool, avatar_url: ?string} $defaults */
@endphp
<div class="admin-modal" id="testimonial-form-modal" hidden>
  <div class="admin-modal__backdrop" data-admin-modal-close></div>
  <div class="admin-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="testimonial-modal-title">
    <div class="admin-modal__header">
      <div>
        <h2 id="testimonial-modal-title" class="admin-modal__title">New testimonial</h2>
        <p id="testimonial-modal-subtitle" class="admin-modal__subtitle">Add a client quote for the marketing site.</p>
      </div>
      <button type="button" class="admin-modal__close" data-admin-modal-close aria-label="Close">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
      </button>
    </div>

    <form id="testimonial-form"
      method="POST"
      action="{{ $storeUrl }}"
      enctype="multipart/form-data"
      data-ajax-form
      data-redirect="false"
      data-reload-table="#admin-datatable"
      data-close-modal="#testimonial-form-modal"
      data-success-message="Testimonial has been created successfully.">
      @csrf
      <input type="hidden" name="_method" value="POST">

      <div class="admin-modal__body space-y-4">
        <div>
          <label class="admin-label" for="testimonial-quote">Quote</label>
          <textarea id="testimonial-quote" name="quote" rows="5" required class="admin-textarea" maxlength="2000"></textarea>
        </div>

        <div class="admin-form-grid admin-form-grid--2">
          <div>
            <label class="admin-label" for="testimonial-name">Name</label>
            <input type="text" id="testimonial-name" name="name" required maxlength="120" class="admin-input">
          </div>
          <div>
            <label class="admin-label" for="testimonial-role">Role / company</label>
            <input type="text" id="testimonial-role" name="role" required maxlength="160" class="admin-input">
          </div>
        </div>

        <div>
          <label class="admin-label" for="testimonial-sort">Sort order</label>
          <input type="number" id="testimonial-sort" name="sort_order" min="0" max="9999" class="admin-input" value="{{ $defaults['sort_order'] ?? 0 }}">
        </div>

        <div>
          <label class="admin-label" for="testimonial-avatar">Avatar image</label>
          <div id="testimonial-avatar-preview" class="mb-2" hidden>
            <img id="testimonial-avatar-img" src="" alt="Client testimonial avatar preview" title="Client testimonial avatar preview" class="h-14 w-14 rounded-full object-cover border border-[var(--admin-border)]">
          </div>
          <div id="testimonial-remove-avatar-wrap" class="mb-2" hidden>
            <label class="admin-check">
              <input type="checkbox" name="remove_avatar" value="1">
              <span>Remove current avatar</span>
            </label>
          </div>
          <input type="file" id="testimonial-avatar" name="avatar" accept="image/*" class="admin-input">
          <p class="mt-1 text-xs text-[var(--admin-muted)]">Optional. Max 2MB. Leave blank to keep the current image.</p>
        </div>

        <div>
          <label class="admin-check">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" name="is_published" value="1" checked>
            <span>Published (visible on the marketing site)</span>
          </label>
        </div>
      </div>

      <div class="admin-modal__footer">
        <button type="button" class="admin-btn admin-btn--secondary" data-admin-modal-close>Cancel</button>
        <button type="submit" id="testimonial-form-submit" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
          <span data-testimonial-submit-label>Save testimonial</span>
        </button>
      </div>
    </form>
  </div>
</div>
