@extends('layouts.admin')

@section('title', 'Contact requests')

@section('content')
  <x-admin.datatable
    title="Contact requests"
    description="Inquiries submitted from the public contact form, including people who left before sending."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Newest', 'column' => 4, 'dir' => 'desc'],
      ['label' => 'Oldest', 'column' => 4, 'dir' => 'asc'],
      ['label' => 'Name A-Z', 'column' => 0, 'dir' => 'asc'],
      ['label' => 'Name Z-A', 'column' => 0, 'dir' => 'desc'],
    ]"
  >
    <x-slot:actions>
      @include('layouts.admin.partials.date-range-filter', ['id' => 'contact-date-range'])
    </x-slot:actions>

    <x-slot:filters>
      <select id="contact-status-filter" class="admin-select admin-select--sm" aria-label="Filter by status">
        <option value="">All statuses</option>
        <option value="draft">Incomplete</option>
        <option value="new">New</option>
        <option value="read">Read</option>
        <option value="archived">Archived</option>
      </select>
    </x-slot:filters>
  </x-admin.datatable>

  @include('admin.contacts.partials.view-modal')
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let table = null;
    const canDelete = @json(auth()->user()->hasPermission('contacts.delete'));

    const dateRange = SuaveAdmin.initDateRangeFilter('#contact-date-range', {
      onChange: function () {
        if (table) {
          SuaveAdmin.reloadDataTable(table, true);
        }
      },
    });

    table = SuaveAdmin.initDataTable('#admin-datatable', {
      ajax: {
        url: @json(route('admin.contacts.index')),
        data: function (d) {
          d.status = document.getElementById('contact-status-filter')?.value || '';
          const range = dateRange ? dateRange.getRange() : {};
          d.date_from = range.from || '';
          d.date_to = range.to || '';
          d.date_preset = range.preset || '';
        },
      },
      columns: @json($columns),
      order: [[4, 'desc']],
    });

    document.getElementById('contact-status-filter')?.addEventListener('change', function () {
      SuaveAdmin.reloadDataTable(table, true);
    });

    // Contact view modal — opens instead of navigating to a separate page.
    const modal = document.getElementById('contact-view-modal');
    const subtitleEl = document.getElementById('contact-view-modal-subtitle');
    const bodyEl = document.getElementById('contact-view-modal-body');
    const archiveBtn = document.getElementById('contact-view-archive');
    const deleteBtn = document.getElementById('contact-view-delete');

    if (modal && bodyEl) {
      let archiveUrl = null;
      let destroyUrl = null;
      let contactName = 'this contact';

      function openView(url) {
        if (!url) {
          return;
        }

        SuaveAdmin.ajax({ url, method: 'GET', data: { _ajax: 1 } })
          .done(function (response) {
            const contact = response.contact || {};
            contactName = contact.name || 'this contact';
            archiveUrl = contact.can_archive ? contact.archive_url : null;
            destroyUrl = contact.destroy_url || null;

            document.getElementById('contact-view-modal-title').textContent = contactName;
            subtitleEl.textContent = [contact.email_display, contact.service, contact.status_label]
              .filter(Boolean)
              .join(' · ');
            bodyEl.innerHTML = contact.detail_html || '';

            if (archiveBtn) {
              archiveBtn.hidden = !archiveUrl;
            }
            if (deleteBtn) {
              deleteBtn.hidden = !canDelete || !destroyUrl;
            }

            SuaveAdmin.openAdminModal(modal);
            // Opening a request marks it read — refresh the row status in the background.
            SuaveAdmin.reloadDataTable(table);
          })
          .fail(function (xhr) {
            SuaveAdmin.toast.validation(xhr, 'Unable to load this contact request.');
          });
      }

      document.addEventListener('click', function (event) {
        const trigger = event.target.closest('[data-contact-view]');
        if (!trigger) {
          return;
        }
        event.preventDefault();
        openView(trigger.getAttribute('data-url'));
      });

      archiveBtn?.addEventListener('click', function () {
        if (!archiveUrl) {
          return;
        }
        SuaveAdmin.confirmRequest(archiveUrl, {
          method: 'PATCH',
          successMessage: 'Contact request has been updated successfully.',
          reloadTable: table,
          redirect: false,
        }).then(function () {
          SuaveAdmin.closeAdminModal(modal);
        });
      });

      deleteBtn?.addEventListener('click', function () {
        if (!destroyUrl) {
          return;
        }
        SuaveAdmin.destroyRecord(destroyUrl, {
          confirm: 'Are you sure you want to delete the request from ' + contactName + '? This cannot be undone.',
          confirmTitle: 'Delete contact request?',
          confirmLabel: 'Delete',
          successMessage: 'Contact request has been deleted successfully.',
          reloadTable: table,
          redirect: false,
        }).then(function () {
          SuaveAdmin.closeAdminModal(modal);
        });
      });
    }
  });
</script>
@endpush
