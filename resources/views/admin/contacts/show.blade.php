@extends('layouts.admin')

@section('title', 'Contact — '.$contact->displayName())

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $contact->displayName() }}</h1>
      <p class="admin-page-desc">
        {{ $contact->email ?: 'No email yet' }}
        · {{ $contact->serviceLabel() }}
        ·
        @if ($contact->isDraft())
          <span class="admin-badge admin-badge--warning">Incomplete</span>
        @elseif ($contact->status === 'new')
          <span class="admin-badge admin-badge--success">New</span>
        @elseif ($contact->status === 'read')
          <span class="admin-badge admin-badge--muted">Read</span>
        @else
          <span class="admin-badge">Archived</span>
        @endif
      </p>
    </div>
    <div class="admin-page-head__actions">
      <a href="{{ route('admin.contacts.index') }}" class="admin-btn admin-btn--secondary">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        Back
      </a>
      @if ($contact->status !== 'archived')
        <form method="POST" action="{{ route('admin.contacts.archive', $contact) }}" data-ajax-form data-success-message="Contact request has been updated successfully.">
          @csrf
          @method('PATCH')
          <button type="submit" class="admin-btn admin-btn--secondary">
            <i class="fa-solid fa-box-archive" aria-hidden="true"></i>
            Archive
          </button>
        </form>
      @endif
      @if (auth()->user()->hasPermission('contacts.delete'))
        <button type="button" class="admin-btn admin-btn--danger" data-admin-delete
          data-url="{{ route('admin.contacts.destroy', $contact) }}"
          data-confirm="Are you sure you want to delete the request from {{ $contact->displayName() }}? This cannot be undone."
          data-confirm-title="Delete contact request?" data-confirm-label="Delete"
          data-success-message="Contact request has been deleted successfully." data-reload-table="">
          <i class="fa-solid fa-trash" aria-hidden="true"></i>
          Delete
        </button>
      @endif
    </div>
  </div>

  <section class="admin-card">
    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">Inquiry details</h2>
      </div>
    </div>
    <div class="admin-card__body">
      @include('admin.contacts.partials.detail', ['contact' => $contact])
    </div>
  </section>
@endsection
