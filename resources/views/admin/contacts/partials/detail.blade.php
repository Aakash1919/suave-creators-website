@php
    /** @var \App\Models\ContactRequest $contact */
@endphp
<div class="space-y-5">
  <p class="text-xs text-[var(--admin-muted)]">
    @if ($contact->isDraft())
      Left the form before sending
      · Last updated {{ optional($contact->updated_at)->format('M j, Y · g:i A') }}
    @else
      Received {{ optional($contact->created_at)->format('M j, Y · g:i A') }}
    @endif
  </p>

  <div class="admin-form-grid admin-form-grid--2">
    <div>
      <p class="admin-label">Phone</p>
      <p class="text-sm text-[var(--admin-text)]">
        @if (trim((string) $contact->phone) !== '')
          <a href="tel:{{ preg_replace('/\s+/', '', $contact->phone) }}" class="text-[var(--admin-primary)] hover:underline">{{ $contact->phone }}</a>
        @else
          —
        @endif
      </p>
    </div>
    <div>
      <p class="admin-label">Email</p>
      <p class="text-sm text-[var(--admin-text)]">
        @if (trim((string) $contact->email) !== '')
          <a href="mailto:{{ $contact->email }}" class="text-[var(--admin-primary)] hover:underline">{{ $contact->email }}</a>
        @else
          —
        @endif
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
    <div class="admin-contact-message">{{ $contact->message ?: '—' }}</div>
  </div>

  @if ($contact->user_agent)
    <div>
      <p class="admin-label">User agent</p>
      <p class="text-xs text-[var(--admin-muted)] break-all">{{ $contact->user_agent }}</p>
    </div>
  @endif
</div>
