@extends('layouts.admin')

@section('title', 'AI Conversations')

@section('content')
  <x-admin.datatable
    title="AI conversations"
    description="SuaveAgent chat leads and conversation transcripts."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Latest', 'column' => 3, 'dir' => 'desc'],
      ['label' => 'Oldest', 'column' => 3, 'dir' => 'asc'],
      ['label' => 'Name A-Z', 'column' => 0, 'dir' => 'asc'],
      ['label' => 'Name Z-A', 'column' => 0, 'dir' => 'desc'],
    ]"
  >
    <x-slot:actions>
      @include('layouts.admin.partials.date-range-filter', ['id' => 'conversation-date-range'])
    </x-slot:actions>

    <x-slot:filters>
      <label class="admin-check">
        <input type="checkbox" id="conversation-escalated-filter" value="1">
        Escalated only
      </label>
    </x-slot:filters>
  </x-admin.datatable>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let table = null;

    const dateRange = SuaveAdmin.initDateRangeFilter('#conversation-date-range', {
      onChange: function () {
        if (table) {
          SuaveAdmin.reloadDataTable(table, true);
        }
      },
    });

    table = SuaveAdmin.initDataTable('#admin-datatable', {
      ajax: {
        url: @json(route('admin.conversations.index')),
        data: function (d) {
          d.escalated_only = document.getElementById('conversation-escalated-filter')?.checked ? 1 : 0;
          const range = dateRange ? dateRange.getRange() : {};
          d.date_from = range.from || '';
          d.date_to = range.to || '';
          d.date_preset = range.preset || '';
        },
      },
      columns: @json($columns),
      order: [[3, 'desc']],
    });

    document.getElementById('conversation-escalated-filter')?.addEventListener('change', function () {
      SuaveAdmin.reloadDataTable(table, true);
    });
  });
</script>
@endpush
