@extends('layouts.admin')

@section('title', 'Blogs')

@section('content')
  <x-admin.datatable
    title="Blogs"
    description="Create and edit marketing blog posts for the public site."
    :columns="$columns"
    :sort-options="[
      ['label' => 'Latest', 'column' => 4, 'dir' => 'desc'],
      ['label' => 'Oldest', 'column' => 4, 'dir' => 'asc'],
      ['label' => 'Title A-Z', 'column' => 0, 'dir' => 'asc'],
      ['label' => 'Title Z-A', 'column' => 0, 'dir' => 'desc'],
    ]"
  >
    <x-slot:actions>
      @include('layouts.admin.partials.date-range-filter', ['id' => 'blog-date-range'])
      @if (Auth::user()->hasPermission('blogs.create'))
        <a href="{{ route('admin.blogs.create') }}" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
          New blog
        </a>
      @endif
    </x-slot:actions>

    <x-slot:filters>
      <select id="blog-category-filter" class="admin-select" style="max-width:14rem" aria-label="Category">
        <option value="">All categories</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
      <select id="blog-status-filter" class="admin-select" style="max-width:12rem" aria-label="Status">
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

    const dateRange = SuaveAdmin.initDateRangeFilter('#blog-date-range', {
      onChange: function () {
        if (table) {
          SuaveAdmin.reloadDataTable(table, true);
        }
      },
    });

    table = SuaveAdmin.initDataTable('#admin-datatable', {
      ajax: {
        url: @json(route('admin.blogs.index')),
        data: function (d) {
          d.category_filter = document.getElementById('blog-category-filter')?.value || '';
          d.status_filter = document.getElementById('blog-status-filter')?.value || '';
          const range = dateRange ? dateRange.getRange() : {};
          d.date_from = range.from || '';
          d.date_to = range.to || '';
          d.date_preset = range.preset || '';
        },
      },
      columns: @json($columns),
      order: [[4, 'desc']],
    });

    ['blog-category-filter', 'blog-status-filter'].forEach(function (id) {
      document.getElementById(id)?.addEventListener('change', function () {
        SuaveAdmin.reloadDataTable(table, true);
      });
    });
  });
</script>
@endpush
