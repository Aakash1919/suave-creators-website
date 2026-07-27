{{-- jQuery + DataTables + Toastr + Flatpickr runtime (auth admin shell) --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@include('layouts.admin.partials.flatpickr-styles')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
@include('layouts.admin.partials.flatpickr-scripts')
<script src="{{ asset('js/admin/suave-admin.js') }}?v={{ file_exists(public_path('js/admin/suave-admin.js')) ? filemtime(public_path('js/admin/suave-admin.js')) : 1 }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (window.SuaveAdmin) {
      window.SuaveAdmin.boot(window.SuaveAdminFlash || {});
    }
  });
</script>
