{{-- Toastr CDN + flash bridge — https://codeseven.github.io/toastr/ --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script>
  window.SuaveAdminFlash = {
    status: @json(session('status')),
    error: @json(session('error')),
    warning: @json(session('warning')),
    info: @json(session('info')),
    errors: @json($errors->any() ? $errors->all() : []),
  };
</script>
