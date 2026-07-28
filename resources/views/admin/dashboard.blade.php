@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">Welcome back, {{ $user->name }}</h1>
      <p class="admin-page-desc">Here’s what’s happening across your Suave Creators admin panel.</p>
    </div>
    @if ($canSeoAudit)
      <div class="admin-page-head__actions">
        <form method="POST" action="{{ route('admin.seo-audit-report.generate') }}" data-ajax-form data-loading-text="Generating report…">
          @csrf
          <button type="submit" class="admin-btn admin-btn--primary" data-loading-text="Generating report…" title="Crawl all public pages and deliver the SEO report (currently via {{ $seoReportMailer }}) to {{ $seoReportTo }}">
            <i class="fa-solid fa-chart-simple" aria-hidden="true"></i>
            Generate SEO report
          </button>
        </form>
      </div>
    @endif
  </div>

  @if ($stats->isNotEmpty())
    <div class="admin-stats">
      @foreach ($stats as $stat)
        <a href="{{ route($stat['route']) }}" class="admin-stat">
          <div class="admin-stat__icon {{ $stat['tone'] ? 'admin-stat__icon--'.$stat['tone'] : '' }}">
            <i class="fa-solid {{ $stat['icon'] }}" aria-hidden="true"></i>
          </div>
          <div class="admin-stat__meta">
            <span class="admin-stat__label">{{ $stat['label'] }}</span>
            <span class="admin-stat__value">{{ $stat['value'] }}</span>
            @if ($stat['hint'])
              <span class="admin-stat__hint">{{ $stat['hint'] }}</span>
            @endif
          </div>
        </a>
      @endforeach
    </div>
  @endif

  <div class="admin-card">
    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">Quick access</h2>
        <p>Jump into the areas your role can manage.</p>
      </div>
    </div>
    <div class="admin-card__body">
      @if ($links->isEmpty())
        <div class="admin-alert admin-alert--warning" style="margin:0">
          <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
          <div>Your account is signed in, but no permissions are assigned yet. Ask an administrator to grant access.</div>
        </div>
      @else
        <div class="admin-quick-grid">
          @foreach ($links as $link)
            <a href="{{ route($link['route']) }}" class="admin-quick-link">
              <span class="admin-quick-link__icon">
                <i class="fa-solid {{ $link['icon'] }}" aria-hidden="true"></i>
              </span>
              <span>
                <strong>{{ $link['label'] }}</strong>
                <span>{{ $link['description'] }}</span>
              </span>
            </a>
          @endforeach
        </div>
      @endif
    </div>
  </div>
@endsection
