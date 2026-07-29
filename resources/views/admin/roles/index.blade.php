@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
  <x-admin.datatable
    title="Roles"
    description="Create roles and assign permissions for the admin panel."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Role A-Z', 'column' => 0, 'dir' => 'asc'],
      ['label' => 'Role Z-A', 'column' => 0, 'dir' => 'desc'],
      ['label' => 'Most permissions', 'column' => 1, 'dir' => 'desc'],
    ]"
  >
    <x-slot:actions>
      @if ($canManage)
        <a href="{{ route('admin.roles.create') }}" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
          New role
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
        url: @json(route('admin.roles.index')),
      },
      columns: @json($columns),
      order: [[0, 'asc']],
    });
  });
</script>
@endpush
