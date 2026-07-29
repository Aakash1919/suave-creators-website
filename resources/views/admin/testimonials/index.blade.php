@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
  <x-admin.datatable
    title="Testimonials"
    description="Client quotes shown on the marketing site."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Order low-high', 'column' => 2, 'dir' => 'asc'],
      ['label' => 'Order high-low', 'column' => 2, 'dir' => 'desc'],
      ['label' => 'Name A-Z', 'column' => 0, 'dir' => 'asc'],
    ]"
  >
    <x-slot:actions>
      @if ($canManage)
        <button type="button" class="admin-btn admin-btn--primary" data-testimonial-create>
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
          New testimonial
        </button>
      @endif
    </x-slot:actions>

    <x-slot:filters>
      <label class="sr-only" for="testimonial-status-filter">Status</label>
      <select id="testimonial-status-filter" class="admin-select" data-admin-filter="status_filter">
        <option value="">All statuses</option>
        <option value="published">Published</option>
        <option value="draft">Draft</option>
      </select>
    </x-slot:filters>
  </x-admin.datatable>

  @if ($canManage)
    @include('admin.testimonials.partials.form-modal', [
      'defaults' => $defaults,
      'storeUrl' => route('admin.testimonials.store'),
    ])
  @endif
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const storeUrl = @json(route('admin.testimonials.store'));
    const defaults = @json($defaults);
    const modal = document.getElementById('testimonial-form-modal');
    const form = document.getElementById('testimonial-form');
    if (!modal || !form) {
      SuaveAdmin.initDataTable('#admin-datatable', {
        ajax: {
          url: @json(route('admin.testimonials.index')),
          data: function (d) {
            d.status_filter = document.getElementById('testimonial-status-filter')?.value || '';
          },
        },
        columns: @json($columns),
        order: [[2, 'asc']],
      });
      return;
    }

    const titleEl = document.getElementById('testimonial-modal-title');
    const subtitleEl = document.getElementById('testimonial-modal-subtitle');
    const methodInput = form.querySelector('input[name="_method"]');
    const submitLabel = form.querySelector('[data-testimonial-submit-label]');
    const avatarPreview = document.getElementById('testimonial-avatar-preview');
    const avatarImg = document.getElementById('testimonial-avatar-img');
    const galleryIdInput = form.querySelector('[data-gallery-id-input]');
    const removeAvatar = form.querySelector('[data-gallery-remove-input]');
    const clearBtn = form.querySelector('[data-gallery-clear]');

    function setField(name, value) {
      const checkbox = form.querySelector('input[name="' + name + '"][type="checkbox"]');
      if (checkbox) {
        checkbox.checked = !!value;
        return;
      }
      const field = form.elements.namedItem(name);
      if (!field) return;
      field.value = value ?? '';
    }

    function resetAvatarUi(url) {
      if (galleryIdInput) galleryIdInput.value = '';
      if (removeAvatar) removeAvatar.value = '0';

      if (url) {
        avatarImg.src = url;
        avatarPreview.hidden = false;
        if (clearBtn) clearBtn.hidden = false;
      } else {
        avatarImg.removeAttribute('src');
        avatarPreview.hidden = true;
        if (clearBtn) clearBtn.hidden = true;
      }
    }

    function fillForm(data, mode) {
      const isEdit = mode === 'edit';
      titleEl.textContent = isEdit ? 'Edit testimonial' : 'New testimonial';
      subtitleEl.textContent = isEdit
        ? 'Update this client quote for the marketing site.'
        : 'Add a client quote for the marketing site.';
      form.action = isEdit ? data.update_url : storeUrl;
      methodInput.value = isEdit ? 'PUT' : 'POST';
      form.dataset.successMessage = isEdit
        ? 'Testimonial has been updated successfully.'
        : 'Testimonial has been created successfully.';
      if (submitLabel) {
        submitLabel.textContent = isEdit ? 'Update testimonial' : 'Save testimonial';
      }

      setField('quote', data.quote || '');
      setField('name', data.name || '');
      setField('role', data.role || '');
      setField('sort_order', data.sort_order ?? 0);
      setField('is_published', data.is_published !== false && data.is_published !== 0);
      resetAvatarUi(data.avatar_url || '');
    }

    function openCreate() {
      fillForm(defaults, 'create');
      SuaveAdmin.openAdminModal(modal);
    }

    function openEdit(url) {
      SuaveAdmin.ajax({
        url,
        method: 'GET',
        data: { _ajax: 1 },
      }).done(function (response) {
        fillForm(response.testimonial || {}, 'edit');
        SuaveAdmin.openAdminModal(modal);
      }).fail(function (xhr) {
        SuaveAdmin.toast.validation(xhr, 'Unable to load this testimonial.');
      });
    }

    document.querySelector('[data-testimonial-create]')?.addEventListener('click', openCreate);

    document.addEventListener('click', function (event) {
      const btn = event.target.closest('[data-testimonial-edit]');
      if (!btn) return;
      event.preventDefault();
      openEdit(btn.getAttribute('data-url'));
    });

    SuaveAdmin.initDataTable('#admin-datatable', {
      ajax: {
        url: @json(route('admin.testimonials.index')),
        data: function (d) {
          d.status_filter = document.getElementById('testimonial-status-filter')?.value || '';
        },
      },
      columns: @json($columns),
      order: [[2, 'asc']],
    });

    document.getElementById('testimonial-status-filter')?.addEventListener('change', function () {
      SuaveAdmin.reloadDataTable('#admin-datatable');
    });
  });
</script>
@endpush
