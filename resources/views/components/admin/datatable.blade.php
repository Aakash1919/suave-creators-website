@php
    $hasFilters = isset($filters) && filled(trim((string) $filters));
    $toolBtn = 'inline-flex items-center gap-2 min-h-[2.1rem] px-3 py-1.5 rounded-lg border border-[var(--admin-border)] bg-white text-[var(--admin-text)] text-sm font-medium cursor-pointer select-none hover:border-[#cfcaff] hover:bg-[var(--admin-primary-soft)] hover:text-[var(--admin-primary)]';
    $menuPanel = 'absolute right-0 z-30 mt-1.5 min-w-[11rem] rounded-lg border border-[var(--admin-border)] bg-white p-1.5 shadow-[0_10px_28px_rgba(15,23,42,0.12)]';
    $menuItem = 'flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-[var(--admin-text)] hover:bg-[var(--admin-primary-soft)] hover:text-[var(--admin-primary)]';
@endphp

<div {{ $attributes->class(['admin-datatable-page']) }}>
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $title }}</h1>
      @if ($description)
        <p class="admin-page-desc">{{ $description }}</p>
      @endif
    </div>
    @isset($actions)
      <div class="admin-page-head__actions">
        {{ $actions }}
      </div>
    @endisset
  </div>

  <div
    class="admin-dt"
    data-admin-datatable
    data-table-id="{{ $tableId }}"
  >
    <div class="admin-card admin-dt__card overflow-visible">
      <div class="admin-dt__toolbar flex flex-wrap items-center justify-between gap-3 border-b border-[var(--admin-border)] px-4 py-3">
        <div class="flex flex-nowrap items-center gap-2.5 min-w-0 overflow-x-auto">
          <div class="relative inline-flex shrink-0 min-w-[12rem] items-center">
            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 text-[0.75rem] text-[var(--admin-muted)]" aria-hidden="true"></i>
            <input
              type="search"
              data-dt-search
              placeholder="Search"
              aria-label="Search"
              class="admin-input admin-dt__search-input w-full min-w-[12rem] !pl-9"
            >
          </div>

          @if ($hasFilters)
            <div class="admin-dt__filters-inline flex flex-nowrap items-center gap-2.5 shrink-0">
              {{ $filters }}
            </div>
          @endif
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
          @if (count($sortOptions) > 0)
            <details class="relative" data-dt-sort>
              <summary class="{{ $toolBtn }} list-none [&::-webkit-details-marker]:hidden">
                <span data-dt-sort-label>Sort By: {{ $sortOptions[0]['label'] ?? 'Latest' }}</span>
                <i class="fa-solid fa-chevron-down text-xs opacity-70" aria-hidden="true"></i>
              </summary>
              <div class="{{ $menuPanel }}">
                @foreach ($sortOptions as $index => $option)
                  <button
                    type="button"
                    class="{{ $menuItem }} {{ $index === 0 ? 'bg-[var(--admin-primary)] text-white hover:bg-[var(--admin-primary)] hover:text-white' : '' }}"
                    data-dt-sort-option
                    data-column="{{ (int) ($option['column'] ?? 0) }}"
                    data-dir="{{ ($option['dir'] ?? 'desc') === 'asc' ? 'asc' : 'desc' }}"
                  >
                    {{ $option['label'] ?? 'Option' }}
                  </button>
                @endforeach
              </div>
            </details>
          @endif

          @if ($showColumnToggle)
            <details class="relative" data-dt-cols>
              <summary class="{{ $toolBtn }} list-none [&::-webkit-details-marker]:hidden">
                <i class="fa-solid fa-table-columns" aria-hidden="true"></i>
                <span>Column</span>
                <i class="fa-solid fa-chevron-down text-xs opacity-70" aria-hidden="true"></i>
              </summary>
              <div class="{{ $menuPanel }} min-w-[12rem]" data-dt-cols-menu>
                @foreach ($columns as $index => $column)
                  @php
                    $colTitle = trim((string) ($column['title'] ?? ''));
                  @endphp
                  @continue($colTitle === '' || strcasecmp($colTitle, 'Action') === 0)
                  <label class="{{ $menuItem }} cursor-pointer">
                    <input
                      type="checkbox"
                      class="accent-[var(--admin-primary)]"
                      data-dt-col="{{ $index }}"
                      checked
                    >
                    <span>{{ $colTitle }}</span>
                  </label>
                @endforeach
              </div>
            </details>
          @endif
        </div>
      </div>

      <div class="admin-card__body admin-card__body--flush">
        <table id="{{ $tableId }}" class="admin-table display nowrap w-full" style="width:100%">
          <thead>
            <tr>
              @foreach ($columns as $column)
                <th>{{ $column['title'] ?? '' }}</th>
              @endforeach
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
