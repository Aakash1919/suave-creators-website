<div class="admin-confirm" data-admin-confirm hidden>
  <div class="admin-confirm__backdrop" data-admin-confirm-backdrop></div>
  <div
    class="admin-confirm__dialog"
    data-admin-confirm-dialog
    role="dialog"
    aria-modal="true"
    aria-labelledby="admin-confirm-title"
    aria-describedby="admin-confirm-message"
  >
    <div class="admin-confirm__panel">
      <div class="admin-confirm__icon" data-admin-confirm-icon aria-hidden="true">
        <i class="fa-solid fa-circle-question" data-admin-confirm-icon-glyph></i>
      </div>
      <div class="admin-confirm__copy">
        <h2 id="admin-confirm-title" class="admin-confirm__title" data-admin-confirm-title>Are you sure?</h2>
        <p id="admin-confirm-message" class="admin-confirm__message" data-admin-confirm-message>
          This action cannot be undone.
        </p>
      </div>
    </div>
    <div class="admin-confirm__actions">
      <button type="button" class="admin-btn admin-btn--secondary" data-admin-confirm-cancel>Cancel</button>
      <button type="button" class="admin-btn admin-btn--primary" data-admin-confirm-ok>Confirm</button>
    </div>
  </div>
</div>
