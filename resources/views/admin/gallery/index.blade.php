@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">Gallery</h1>
      <p class="admin-page-desc">Upload images once, then reuse them on blogs and testimonials.</p>
    </div>
    <div class="admin-page-head__actions">
      <form method="GET" action="{{ route('admin.gallery.index') }}" class="admin-gallery-search">
        <label class="sr-only" for="gallery-search">Search gallery</label>
        <input id="gallery-search" type="search" name="search" value="{{ $search }}"
          class="admin-input" placeholder="Search title or alt…">
        <button type="submit" class="admin-btn admin-btn--secondary">Search</button>
      </form>
      @if ($canManage)
        <a href="{{ route('admin.gallery.create') }}" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
          Add image
        </a>
      @endif
    </div>
  </div>

  @if ($images->isEmpty())
    <div class="admin-card">
      <div class="admin-card__body">
        <p class="text-[var(--admin-muted)]">
          @if ($search !== '')
            No images match “{{ $search }}”.
          @else
            No gallery images yet.
            @if ($canManage)
              <a href="{{ route('admin.gallery.create') }}" class="text-[var(--admin-primary)]">Upload the first one</a>.
            @endif
          @endif
        </p>
      </div>
    </div>
  @else
    <div class="admin-gallery-grid">
      @foreach ($images as $image)
        <article class="admin-gallery-card">
          <div class="admin-gallery-card__media">
            <img src="{{ $image->mediumThumbUrl() ?? $image->url() }}"
              alt="{{ $image->alt_text ?: ($image->title ?: 'Gallery image') }}">
          </div>
          <div class="admin-gallery-card__body">
            <h2 class="admin-gallery-card__title">{{ $image->title ?: 'Untitled' }}</h2>
            @if ($image->alt_text)
              <p class="admin-gallery-card__meta">{{ $image->alt_text }}</p>
            @endif
            @if ($canManage)
              <div class="admin-gallery-card__actions">
                <a href="{{ route('admin.gallery.edit', $image) }}" class="admin-btn admin-btn--secondary admin-btn--sm">
                  Edit
                </a>
                <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" data-admin-delete
                  data-url="{{ route('admin.gallery.destroy', $image) }}"
                  data-confirm="Delete “{{ $image->title ?: 'this image' }}”? Only allowed if unused by blogs or testimonials."
                  data-confirm-title="Delete image?"
                  data-confirm-label="Delete"
                  data-reload-table="">
                  Delete
                </button>
              </div>
            @endif
          </div>
        </article>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $images->links() }}
    </div>
  @endif
@endsection
