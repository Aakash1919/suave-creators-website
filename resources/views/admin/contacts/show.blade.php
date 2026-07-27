@extends('layouts.admin')

@section('title', 'Contact — '.$contact->name)

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $contact->name }}</h1>
      <p class="admin-page-desc">
        {{ $contact->email }}
        · {{ $contact->serviceLabel() }}
        ·
        @if ($contact->status === 'new')
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
    </div>
  </div>

  <section class="admin-card">
    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">Inquiry details</h2>
        <p>Received {{ optional($contact->created_at)->format('M j, Y · g:i A') }}</p>
      </div>
    </div>
    <div class="admin-card__body space-y-5">
      <div class="admin-form-grid admin-form-grid--2">
        <div>
          <p class="admin-label">Phone</p>
          <p class="text-sm text-[var(--admin-text)]">
            <a href="tel:{{ preg_replace('/\s+/', '', $contact->phone) }}" class="text-[var(--admin-primary)] hover:underline">{{ $contact->phone }}</a>
          </p>
        </div>
        <div>
          <p class="admin-label">Email</p>
          <p class="text-sm text-[var(--admin-text)]">
            <a href="mailto:{{ $contact->email }}" class="text-[var(--admin-primary)] hover:underline">{{ $contact->email }}</a>
          </p>
        </div>
        <div>
          <p class="admin-label">Service</p>
          <p class="text-sm text-[var(--admin-text)]">{{ $contact->serviceLabel() }}</p>
        </div>
        <div>
          <p class="admin-label">IP address</p>
          <p class="text-sm text-[var(--admin-muted)]">{{ $contact->ip_address ?: '—' }}</p>
        </div>
      </div>

      <div>
        <p class="admin-label">Message</p>
        <div class="admin-contact-message">{{ $contact->message }}</div>
      </div>

      @if ($contact->user_agent)
        <div>
          <p class="admin-label">User agent</p>
          <p class="text-xs text-[var(--admin-muted)] break-all">{{ $contact->user_agent }}</p>
        </div>
      @endif
    </div>
  </section>
@endsection
