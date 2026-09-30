@php
  /** @var array{name: string, slug: string, sort_order: int} $defaults */
@endphp
<div class="admin-modal" id="blog-category-form-modal" hidden>
  <div class="admin-modal__backdrop" data-admin-modal-close></div>
  <div class="admin-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="blog-category-modal-title">
    <div class="admin-modal__header">
      <div>
        <h2 id="blog-category-modal-title" class="admin-modal__title">New category</h2>
        <p id="blog-category-modal-subtitle" class="admin-modal__subtitle">Add a category for blog posts.</p>
      </div>
      <button type="button" class="admin-modal__close" data-admin-modal-close aria-label="Close">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
      </button>
    </div>

    <form id="blog-category-form"
      method="POST"
      action="{{ $storeUrl }}"
      data-ajax-form
      data-redirect="false"
      data-reload-table="#admin-datatable"
      data-close-modal="#blog-category-form-modal"
      data-success-message="Blog category has been created successfully.">
      @csrf
      <input type="hidden" name="_method" value="POST">

      <div class="admin-modal__body space-y-4">
        <div>
          <label class="admin-label" for="blog-category-name">Name</label>
          <input type="text" id="blog-category-name" name="name" required maxlength="120" class="admin-input">
        </div>
        <div>
          <label class="admin-label" for="blog-category-slug">Slug</label>
          <input type="text" id="blog-category-slug" name="slug" maxlength="120" class="admin-input" placeholder="Auto from name if empty">
          <p class="admin-help">Used in the public URL /blogs/category/{slug}. A category appears there after a post in it is published.</p>
        </div>
        <div>
          <label class="admin-label" for="blog-category-sort">Sort order</label>
          <input type="number" id="blog-category-sort" name="sort_order" min="0" max="9999" class="admin-input" value="{{ $defaults['sort_order'] ?? 0 }}">
        </div>
      </div>

      <div class="admin-modal__footer">
        <button type="button" class="admin-btn admin-btn--secondary" data-admin-modal-close>Cancel</button>
        <button type="submit" id="blog-category-form-submit" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
          <span data-blog-category-submit-label>Save category</span>
        </button>
      </div>
    </form>
  </div>
</div>
