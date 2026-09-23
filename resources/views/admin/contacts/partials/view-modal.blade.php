<div class="admin-modal" id="contact-view-modal" hidden>
  <div class="admin-modal__backdrop" data-admin-modal-close></div>
  <div class="admin-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="contact-view-modal-title">
    <div class="admin-modal__header">
      <div>
        <h2 id="contact-view-modal-title" class="admin-modal__title">Contact request</h2>
        <p id="contact-view-modal-subtitle" class="admin-modal__subtitle"></p>
      </div>
      <button type="button" class="admin-modal__close" data-admin-modal-close aria-label="Close">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
      </button>
    </div>

    <div class="admin-modal__body" id="contact-view-modal-body"></div>

    <div class="admin-modal__footer">
      <button type="button" class="admin-btn admin-btn--secondary" data-admin-modal-close>Close</button>
      <button type="button" class="admin-btn admin-btn--secondary" id="contact-view-archive" hidden>
        <i class="fa-solid fa-box-archive" aria-hidden="true"></i>
        Archive
      </button>
      <button type="button" class="admin-btn admin-btn--danger" id="contact-view-delete" hidden>
        <i class="fa-solid fa-trash" aria-hidden="true"></i>
        Delete
      </button>
    </div>
  </div>
</div>
