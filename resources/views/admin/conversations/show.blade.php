@extends('layouts.admin')

@section('title', 'Conversation — '.$lead->name)

@section('content')
  <div class="admin-messenger" data-admin-messenger>
    <header class="admin-messenger__top">
      <a href="{{ route('admin.conversations.index') }}" class="admin-messenger__back" aria-label="Back to conversations">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
      </a>
      <div class="admin-messenger__identity">
        <span class="admin-messenger__avatar" aria-hidden="true">{{ $leadInitials }}</span>
        <div class="admin-messenger__identity-copy">
          <h1 class="admin-messenger__name">{{ $lead->name }}</h1>
          <p class="admin-messenger__meta">
            <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a>
            @if ($lead->escalated_at)
              <span class="admin-messenger__pill admin-messenger__pill--danger">Escalated {{ $lead->escalated_at->diffForHumans() }}</span>
            @else
              <span class="admin-messenger__pill">SuaveAgent</span>
            @endif
          </p>
        </div>
      </div>
    </header>

    @if ($threads->isEmpty())
      <div class="admin-messenger__empty">
        <i class="fa-regular fa-comments" aria-hidden="true"></i>
        <p>No conversation threads for this lead.</p>
      </div>
    @else
      <div class="admin-messenger__body {{ $threads->count() > 1 ? 'admin-messenger__body--split' : '' }}">
        @if ($threads->count() > 1)
          <aside class="admin-messenger__rail" aria-label="Conversation threads">
            <p class="admin-messenger__rail-label">Threads</p>
            <div class="admin-messenger__thread-list">
              @foreach ($threads as $index => $thread)
                <button
                  type="button"
                  class="admin-messenger__thread {{ $index === 0 ? 'is-active' : '' }}"
                  data-messenger-thread="{{ $thread['id'] }}"
                >
                  <span class="admin-messenger__thread-title">{{ $thread['title'] }}</span>
                  <span class="admin-messenger__thread-preview">{{ $thread['preview'] }}</span>
                  <span class="admin-messenger__thread-meta">
                    {{ $thread['message_count'] }} {{ Str::plural('message', $thread['message_count']) }}
                    · {{ optional($thread['updated_at'])->diffForHumans() ?? '—' }}
                  </span>
                </button>
              @endforeach
            </div>
          </aside>
        @endif

        <div class="admin-messenger__stage">
          @foreach ($threads as $index => $thread)
            <section
              class="admin-messenger__pane {{ $index === 0 ? 'is-active' : '' }}"
              data-messenger-pane="{{ $thread['id'] }}"
              @if ($index !== 0) hidden @endif
            >
              <div class="admin-messenger__pane-head">
                <div>
                  <h2 class="admin-messenger__pane-title">{{ $thread['title'] }}</h2>
                  <p class="admin-messenger__pane-sub">
                    Updated {{ optional($thread['updated_at'])->format('M j, Y · g:i A') ?? '—' }}
                  </p>
                </div>
              </div>

              <div class="admin-messenger__stream" data-messenger-stream>
                @php
                  $lastDate = null;
                @endphp
                @forelse ($thread['messages'] as $message)
                  @php
                    $messageDate = optional($message['created_at'])?->format('Y-m-d');
                    $showDay = $messageDate && $messageDate !== $lastDate;
                    $lastDate = $messageDate ?: $lastDate;
                    $isAssistant = $message['role'] === 'assistant';
                  @endphp

                  @if ($showDay)
                    <div class="admin-messenger__day">
                      <span>{{ optional($message['created_at'])->format('M j, Y') }}</span>
                    </div>
                  @endif

                  <article class="admin-messenger__row admin-messenger__row--{{ $isAssistant ? 'assistant' : 'user' }}">
                    @if ($isAssistant)
                      <span class="admin-messenger__bubble-avatar" aria-hidden="true">SC</span>
                    @endif
                    <div class="admin-messenger__stack">
                      <div class="admin-messenger__bubble admin-messenger__bubble--{{ $isAssistant ? 'assistant' : 'user' }}">
                        @if ($isAssistant)
                          <div class="admin-messenger__bubble-html prose prose-sm max-w-none">{!! $message['html'] !!}</div>
                        @else
                          <p class="admin-messenger__bubble-text">{!! $message['html'] !!}</p>
                        @endif
                      </div>
                      <time class="admin-messenger__time" datetime="{{ optional($message['created_at'])?->toIso8601String() }}">
                        {{ optional($message['created_at'])->format('g:i A') ?? '' }}
                        · {{ $isAssistant ? 'SuaveAgent' : $lead->name }}
                      </time>
                    </div>
                    @unless ($isAssistant)
                      <span class="admin-messenger__bubble-avatar admin-messenger__bubble-avatar--user" aria-hidden="true">{{ $leadInitials }}</span>
                    @endunless
                  </article>
                @empty
                  <div class="admin-messenger__empty admin-messenger__empty--inline">
                    <p>No messages in this conversation.</p>
                  </div>
                @endforelse
              </div>
            </section>
          @endforeach
        </div>
      </div>
    @endif
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const root = document.querySelector('[data-admin-messenger]');
    if (!root) return;

    const threads = root.querySelectorAll('[data-messenger-thread]');
    const panes = root.querySelectorAll('[data-messenger-pane]');

    function activate(id) {
      threads.forEach(function (btn) {
        btn.classList.toggle('is-active', btn.getAttribute('data-messenger-thread') === id);
      });
      panes.forEach(function (pane) {
        const match = pane.getAttribute('data-messenger-pane') === id;
        pane.classList.toggle('is-active', match);
        pane.hidden = !match;
        if (match) {
          const stream = pane.querySelector('[data-messenger-stream]');
          if (stream) {
            stream.scrollTop = stream.scrollHeight;
          }
        }
      });
    }

    threads.forEach(function (btn) {
      btn.addEventListener('click', function () {
        activate(btn.getAttribute('data-messenger-thread'));
      });
    });

    const active = root.querySelector('.admin-messenger__pane.is-active [data-messenger-stream]');
    if (active) {
      active.scrollTop = active.scrollHeight;
    }
  });
</script>
@endpush
