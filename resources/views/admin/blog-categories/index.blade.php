@extends('layouts.admin')

@section('title', 'Blog categories')

@section('content')
  <x-admin.datatable
    title="Blog categories"
    description="Categories assigned to blog posts. A category shows on the public blog listing after at least one post in it is published."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Order low-high', 'column' => 2, 'dir' => 'asc'],
      ['label' => 'Order high-low', 'column' => 2, 'dir' => 'desc'],
      ['label' => 'Name A-Z', 'column' => 0, 'dir' => 'asc'],
    ]"
  >
    <x-slot:actions>
      @if ($canCreate)
        <button type="button" class="admin-btn admin-btn--primary" data-blog-category-create>
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
          New category
        </button>
      @endif
    </x-slot:actions>
  </x-admin.datatable>

  @if ($canCreate || $canUpdate)
    @include('admin.blog-categories.partials.form-modal', [
      'defaults' => $defaults,
      'storeUrl' => route('admin.blog-categories.store'),
    ])
  @endif
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tableOptions = {
      ajax: {
        url: @json(route('admin.blog-categories.index')),
      },
      columns: @json($columns),
      order: [[2, 'asc']],
    };

    const storeUrl = @json(route('admin.blog-categories.store'));
    const defaults = @json($defaults);
    const modal = document.getElementById('blog-category-form-modal');
    const form = document.getElementById('blog-category-form');

    if (!modal || !form) {
      SuaveAdmin.initDataTable('#admin-datatable', tableOptions);
      return;
    }

    const titleEl = document.getElementById('blog-category-modal-title');
    const subtitleEl = document.getElementById('blog-category-modal-subtitle');
    const methodInput = form.querySelector('input[name="_method"]');
    const submitLabel = form.querySelector('[data-blog-category-submit-label]');

    function setField(name, value) {
      const field = form.elements.namedItem(name);
      if (!field) return;
      field.value = value ?? '';
    }

    function fillForm(data, mode) {
      const isEdit = mode === 'edit';
      titleEl.textContent = isEdit ? 'Edit category' : 'New category';
      subtitleEl.textContent = isEdit
        ? 'Update this category name, slug, or order.'
        : 'Add a category for blog posts.';
      form.action = isEdit ? data.update_url : storeUrl;
      methodInput.value = isEdit ? 'PUT' : 'POST';
      form.dataset.successMessage = isEdit
        ? 'Blog category has been updated successfully.'
        : 'Blog category has been created successfully.';
      if (submitLabel) {
        submitLabel.textContent = isEdit ? 'Update category' : 'Save category';
      }

      setField('name', data.name || '');
      setField('slug', data.slug || '');
      setField('sort_order', data.sort_order ?? 0);
    }

    function openCreate() {
      fillForm(defaults, 'create');
      SuaveAdmin.openAdminModal(modal);
    }

    function openEdit(url) {
      SuaveAdmin.ajax({
        url: url,
        method: 'GET',
        data: { _ajax: 1 },
      }).done(function (response) {
        fillForm(response.category || {}, 'edit');
        SuaveAdmin.openAdminModal(modal);
      }).fail(function (xhr) {
        SuaveAdmin.toast.validation(xhr, 'Unable to load this category.');
      });
    }

    document.querySelector('[data-blog-category-create]')?.addEventListener('click', openCreate);

    document.addEventListener('click', function (event) {
      const button = event.target.closest('[data-blog-category-edit]');
      if (!button) return;
      event.preventDefault();
      openEdit(button.getAttribute('data-url'));
    });

    SuaveAdmin.initDataTable('#admin-datatable', tableOptions);
  });
</script>
@endpush
