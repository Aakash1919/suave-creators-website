@extends('layouts.admin')

@section('title', 'Case studies')

@section('content')
  <x-admin.datatable
    title="Case studies"
    description="Create and edit marketing case studies. The public layout is fixed — fill in the story fields only. Case studies are never auto-generated."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Latest', 'column' => 5, 'dir' => 'desc'],
      ['label' => 'Oldest', 'column' => 5, 'dir' => 'asc'],
      ['label' => 'Order', 'column' => 3, 'dir' => 'asc'],
      ['label' => 'Title A-Z', 'column' => 0, 'dir' => 'asc'],
      ['label' => 'Title Z-A', 'column' => 0, 'dir' => 'desc'],
    ]"
  >
    <x-slot:actions>
      @include('layouts.admin.partials.date-range-filter', ['id' => 'case-study-date-range'])
      @if (Auth::user()->hasPermission('case-studies.create'))
        <a href="{{ route('admin.case-studies.create') }}" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
          New case study
        </a>
      @endif
    </x-slot:actions>

    <x-slot:filters>
      <select id="case-study-status-filter" class="admin-select" style="max-width:12rem" aria-label="Status">
        <option value="">All statuses</option>
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </x-slot:filters>
  </x-admin.datatable>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let table = null;

    const dateRange = SuaveAdmin.initDateRangeFilter('#case-study-date-range', {
      onChange: function () {
        if (table) {
          SuaveAdmin.reloadDataTable(table, true);
        }
      },
    });

    table = SuaveAdmin.initDataTable('#admin-datatable', {
      ajax: {
        url: @json(route('admin.case-studies.index')),
        data: function (d) {
          d.status_filter = document.getElementById('case-study-status-filter')?.value || '';
          const range = dateRange ? dateRange.getRange() : {};
          d.date_from = range.from || '';
          d.date_to = range.to || '';
          d.date_preset = range.preset || '';
        },
      },
      columns: @json($columns),
      order: [[3, 'asc']],
    });

    document.getElementById('case-study-status-filter')?.addEventListener('change', function () {
      SuaveAdmin.reloadDataTable(table, true);
    });
  });
</script>
@endpush
