@if (session('status'))
  <div class="admin-alert admin-alert--success" role="status">
    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
    <div>{{ session('status') }}</div>
  </div>
@endif
@if ($errors->any())
  <div class="admin-alert admin-alert--danger" role="alert">
    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
