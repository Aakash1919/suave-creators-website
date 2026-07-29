{{-- Shared gallery picker modal for blog / testimonial forms --}}
@if (Auth::check() && Auth::user()->hasPermission('gallery.view'))
<div class="admin-modal admin-gallery-picker" id="admin-gallery-picker" hidden
  data-browse-url="{{ route('admin.gallery.browse') }}">
  <div class="admin-modal__backdrop" data-admin-modal-close></div>
  <div class="admin-modal__dialog admin-gallery-picker__dialog" role="dialog" aria-modal="true"
    aria-labelledby="admin-gallery-picker-title">
    <div class="admin-modal__header">
      <div>
        <h2 id="admin-gallery-picker-title" class="admin-modal__title">Choose from gallery</h2>
        <p class="admin-modal__subtitle">Select an uploaded image to use on this form.</p>
      </div>
      <button type="button" class="admin-modal__close" data-admin-modal-close aria-label="Close">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
      </button>
    </div>

    <div class="admin-modal__body">
      <div class="admin-gallery-picker__toolbar">
        <label class="sr-only" for="admin-gallery-picker-search">Search gallery</label>
        <input id="admin-gallery-picker-search" type="search" class="admin-input"
          placeholder="Search title or alt…">
      </div>
      <div id="admin-gallery-picker-grid" class="admin-gallery-picker__grid" aria-live="polite"></div>
      <div id="admin-gallery-picker-empty" class="admin-gallery-picker__empty" hidden>
        No images found. Upload images in Gallery first.
      </div>
      <div id="admin-gallery-picker-pager" class="admin-gallery-picker__pager" hidden>
        <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-gallery-picker-prev>Previous</button>
        <span data-gallery-picker-page></span>
        <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-gallery-picker-next>Next</button>
      </div>
    </div>

    <div class="admin-modal__footer">
      <button type="button" class="admin-btn admin-btn--secondary" data-admin-modal-close>Cancel</button>
    </div>
  </div>
</div>
@endif
