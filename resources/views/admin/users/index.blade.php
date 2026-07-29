@extends('layouts.admin')

@section('title', 'Users')

@section('content')
  <x-admin.datatable
    title="Users"
    description="Manage admin users and role assignment."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Name A-Z', 'column' => 0, 'dir' => 'asc'],
      ['label' => 'Name Z-A', 'column' => 0, 'dir' => 'desc'],
      ['label' => 'Email A-Z', 'column' => 1, 'dir' => 'asc'],
    ]"
  >
    <x-slot:actions>
      @if ($canManage)
        <a href="{{ route('admin.users.create') }}" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
          New user
        </a>
      @endif
    </x-slot:actions>
  </x-admin.datatable>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    SuaveAdmin.initDataTable('#admin-datatable', {
      ajax: {
        url: @json(route('admin.users.index')),
      },
      columns: @json($columns),
      order: [[0, 'asc']],
    });
  });
</script>
@endpush
