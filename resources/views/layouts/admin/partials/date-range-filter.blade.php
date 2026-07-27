@php
  $id = $id ?? 'admin-date-range';
  $defaultPreset = $defaultPreset ?? 'last_30_days';
@endphp

<div class="admin-daterange" data-date-range-filter data-default-preset="{{ $defaultPreset }}" id="{{ $id }}">
  <button type="button" class="admin-daterange__trigger" data-daterange-trigger aria-expanded="false" aria-haspopup="listbox">
    <span data-daterange-label>Loading…</span>
    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
  </button>

  <div class="admin-daterange__menu" data-daterange-menu hidden role="listbox">
    <button type="button" class="admin-daterange__option" data-preset="today">Today</button>
    <button type="button" class="admin-daterange__option" data-preset="yesterday">Yesterday</button>
    <button type="button" class="admin-daterange__option" data-preset="last_7_days">Last 7 Days</button>
    <button type="button" class="admin-daterange__option" data-preset="last_30_days">Last 30 Days</button>
    <button type="button" class="admin-daterange__option" data-preset="this_month">This Month</button>
    <button type="button" class="admin-daterange__option" data-preset="last_month">Last Month</button>
    <button type="button" class="admin-daterange__option" data-preset="custom">Custom Range</button>
  </div>

  <input type="text" class="admin-daterange__picker" data-daterange-picker aria-hidden="true" tabindex="-1">
  <input type="hidden" data-daterange-from name="date_from" value="">
  <input type="hidden" data-daterange-to name="date_to" value="">
  <input type="hidden" data-daterange-preset name="date_preset" value="{{ $defaultPreset }}">
</div>
