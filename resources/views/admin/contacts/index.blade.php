@extends('layouts.admin')

@section('title', 'Contact requests')

@section('content')
  <x-admin.datatable
    title="Contact requests"
    description="Inquiries submitted from the public contact form."
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
        <option value="new">New</option>
        <option value="read">Read</option>
        <option value="archived">Archived</option>
      </select>
    </x-slot:filters>
  </x-admin.datatable>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let table = null;

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
  });
</script>
@endpush
