@extends('layouts.admin')

@section('title', $image->exists ? 'Edit image' : 'Add image')

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $image->exists ? 'Edit image' : 'Add image' }}</h1>
      <p class="admin-page-desc">Gallery images are stored with original, medium, and small variants.</p>
    </div>
    <div class="admin-page-head__actions">
      <a href="{{ route('admin.gallery.index') }}" class="admin-btn admin-btn--secondary">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        Back
      </a>
    </div>
  </div>

  <form method="POST"
    action="{{ $image->exists ? route('admin.gallery.update', $image) : route('admin.gallery.store') }}"
    enctype="multipart/form-data"
    class="admin-card"
    data-ajax-form
    data-success-message="{{ $image->exists ? 'Image has been updated successfully.' : 'Image has been created successfully.' }}">
    @csrf
    @if ($image->exists)
      @method('PUT')
    @endif

    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">Image details</h2>
        <p>Title, alt text, and file.</p>
      </div>
    </div>

    <div class="admin-card__body space-y-4">
      @if ($image->exists && $image->url())
        <div class="admin-gallery-form__preview">
          <img src="{{ $image->mediumThumbUrl() ?? $image->url() }}"
            alt="{{ $image->alt_text ?: ($image->title ?: 'Current image') }}">
        </div>
      @endif

      <div>
        <label class="admin-label" for="gallery-title">Title</label>
        <input id="gallery-title" type="text" name="title" value="{{ old('title', $image->title) }}"
          class="admin-input" maxlength="255">
      </div>

      <div>
        <label class="admin-label" for="gallery-alt">Alt text</label>
        <input id="gallery-alt" type="text" name="alt_text" value="{{ old('alt_text', $image->alt_text) }}"
          class="admin-input" maxlength="255">
      </div>

      <div>
        <label class="admin-label" for="gallery-image">
          Image file {{ $image->exists ? '(leave blank to keep)' : '' }}
        </label>
        <input id="gallery-image" type="file" name="image" accept="image/*"
          class="admin-input" @required(! $image->exists)>
        <p class="mt-1 text-xs text-[var(--admin-muted)]">Max 5MB. Replacing a file is blocked while blogs or testimonials use it.</p>
      </div>

      <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
          {{ $image->exists ? 'Save changes' : 'Upload image' }}
        </button>
        @if ($image->exists)
          <button type="button" class="admin-btn admin-btn--danger" data-admin-delete
            data-url="{{ route('admin.gallery.destroy', $image) }}"
            data-confirm="Delete “{{ $image->title ?: 'this image' }}”? Only allowed if unused by blogs or testimonials."
            data-confirm-title="Delete image?"
            data-confirm-label="Delete"
            data-reload-table="">
            <i class="fa-solid fa-trash" aria-hidden="true"></i>
            Delete
          </button>
        @endif
      </div>
    </div>
  </form>
@endsection
