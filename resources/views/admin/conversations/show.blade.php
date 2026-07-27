@extends('layouts.admin')

@section('title', 'Conversation — '.$lead->name)

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $lead->name }}</h1>
      <p class="admin-page-desc">
        {{ $lead->email }}
        @if ($lead->escalated_at)
          · <span style="color:var(--admin-danger);font-weight:600">Escalated {{ $lead->escalated_at->diffForHumans() }}</span>
        @endif
      </p>
    </div>
    <div class="admin-page-head__actions">
      <a href="{{ route('admin.conversations.index') }}" class="admin-btn admin-btn--secondary">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        Back
      </a>
    </div>
  </div>

  @forelse ($threads as $thread)
    <section class="admin-card mb-4">
      <div class="admin-card__header">
        <div>
          <h2 class="admin-card__title">{{ $thread['title'] ?: 'Conversation' }}</h2>
          <p>{{ optional($thread['updated_at'])->format('Y-m-d H:i') }}</p>
        </div>
      </div>
      <div class="admin-card__body space-y-3">
        @forelse ($thread['messages'] as $message)
          <div class="admin-chat-bubble admin-chat-bubble--{{ $message['role'] === 'assistant' ? 'assistant' : 'user' }}">
            <p class="admin-chat-bubble__role">{{ $message['role'] }}</p>
            @if ($message['role'] === 'assistant')
              <div class="prose prose-sm max-w-none">{!! $message['html'] !!}</div>
            @else
              <p class="whitespace-pre-wrap text-sm text-[var(--admin-text)]">{!! $message['html'] !!}</p>
            @endif
          </div>
        @empty
          <p class="text-sm text-[var(--admin-muted)]">No messages in this conversation.</p>
        @endforelse
      </div>
    </section>
  @empty
    <div class="admin-card">
      <div class="admin-card__body admin-table__empty">No conversation threads for this lead.</div>
    </div>
  @endforelse
@endsection
