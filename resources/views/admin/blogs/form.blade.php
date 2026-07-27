@extends('layouts.admin')

@section('title', $blog->exists ? 'Edit blog' : 'New blog')

@section('content')
  <div class="admin-page-head">
    <div class="admin-page-head__copy">
      <h1 class="admin-page-title">{{ $blog->exists ? 'Edit blog' : 'New blog' }}</h1>
      <p class="admin-page-desc">Content accepts HTML used by the public blog pages.</p>
    </div>
    <div class="admin-page-head__actions">
      <a href="{{ route('admin.blogs.index') }}" class="admin-btn admin-btn--secondary">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        Back to list
      </a>
    </div>
  </div>

  <form method="POST"
    action="{{ $blog->exists ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}"
    enctype="multipart/form-data"
    class="admin-card"
    data-ajax-form
    data-success-message="{{ $blog->exists ? 'Blog has been updated successfully.' : 'Blog has been created successfully.' }}">
    @csrf
    @if ($blog->exists)
      @method('PUT')
    @endif

    <div class="admin-card__header">
      <div>
        <h2 class="admin-card__title">Post details</h2>
        <p>Title, slug, category, and publish settings.</p>
      </div>
    </div>

    <div class="admin-card__body space-y-6">
      <div class="admin-form-grid admin-form-grid--2">
        <div class="span-2">
          <label class="admin-label">Title</label>
          <input type="text" name="title" value="{{ old('title', $blog->title) }}" required class="admin-input">
        </div>
        <div>
          <label class="admin-label">Slug</label>
          <input type="text" name="slug" value="{{ old('slug', $blog->slug) }}" class="admin-input" placeholder="Auto from title if empty">
        </div>
        <div>
          <label class="admin-label">Category</label>
          <select name="blog_category_id" class="admin-select">
            <option value="">None</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" @selected((string) old('blog_category_id', $blog->blog_category_id) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="admin-label">Status</label>
          <select name="status" class="admin-select">
            <option value="draft" @selected(old('status', $blog->status) === 'draft')>Draft</option>
            <option value="published" @selected(old('status', $blog->status) === 'published')>Published</option>
          </select>
        </div>
        <div>
          <label class="admin-label" for="blog-published-at">Published at</label>
          <input id="blog-published-at"
            type="text"
            name="published_at"
            value="{{ old('published_at', optional($blog->published_at)->format('Y-m-d H:i')) }}"
            class="admin-input"
            placeholder="Select date & time"
            data-flatpickr
            data-flatpickr-enable-time="true"
            data-flatpickr-date-format="Y-m-d H:i"
            autocomplete="off">
        </div>
      </div>

      <div>
        <label class="admin-label">Short description</label>
        <textarea name="short_description" rows="3" class="admin-textarea">{{ old('short_description', $blog->short_description) }}</textarea>
      </div>

      <div class="admin-rte">
        <label class="admin-label" for="blog-content">Content</label>
        <textarea id="blog-content" name="content" rows="16" class="admin-textarea">{{ old('content', $blog->content) }}</textarea>
      </div>

      <div>
        <label class="admin-label">Featured image</label>
        @if ($blog->featuredImageUrl())
          <img src="{{ $blog->featuredImageUrl() }}" alt="Current featured image" title="Current featured image" class="admin-thumb mb-3">
        @endif
        <input type="file" name="featured_image" accept="image/*" class="block w-full text-sm text-[var(--admin-gray)]">
      </div>
    </div>

    <div class="admin-card__header" style="border-top:1px solid var(--admin-border);border-bottom:1px solid var(--admin-border);border-radius:0">
      <div>
        <h2 class="admin-card__title">SEO & structured data</h2>
        <p>Meta tags, Open Graph, TOC, and FAQs.</p>
      </div>
    </div>

    <div class="admin-card__body space-y-6">
      <div class="admin-form-grid admin-form-grid--2">
        <div>
          <label class="admin-label">Meta title</label>
          <input type="text" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}" class="admin-input">
        </div>
        <div>
          <label class="admin-label">OG title</label>
          <input type="text" name="og_title" value="{{ old('og_title', $blog->og_title) }}" class="admin-input">
        </div>
        <div>
          <label class="admin-label">Meta description</label>
          <textarea name="meta_description" rows="3" class="admin-textarea">{{ old('meta_description', $blog->meta_description) }}</textarea>
        </div>
        <div>
          <label class="admin-label">OG description</label>
          <textarea name="og_description" rows="3" class="admin-textarea">{{ old('og_description', $blog->og_description) }}</textarea>
        </div>
        <div>
          <label class="admin-label">TOC JSON</label>
          <textarea name="toc_json" rows="6" class="admin-textarea font-mono text-xs">{{ old('toc_json', $blog->toc ? json_encode($blog->toc, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea>
        </div>
        <div>
          <label class="admin-label">FAQs JSON</label>
          <textarea name="faqs_json" rows="6" class="admin-textarea font-mono text-xs">{{ old('faqs_json', $blog->faqs ? json_encode($blog->faqs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea>
        </div>
      </div>

      <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--primary">
          <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
          {{ $blog->exists ? 'Save changes' : 'Create blog' }}
        </button>
        @if ($blog->exists && Auth::user()->hasPermission('blogs.delete'))
          <button type="button"
            class="admin-btn admin-btn--danger"
            data-admin-delete
            data-url="{{ route('admin.blogs.destroy', $blog) }}"
            data-confirm="Are you sure want to delete blog {{ $blog->title }}?"
            data-confirm-title="Delete blog?"
            data-confirm-label="Delete"
            data-success-message="Blog has been deleted successfully."
            data-reload-table="">
            <i class="fa-solid fa-trash" aria-hidden="true"></i>
            Delete
          </button>
        @endif
      </div>
    </div>
  </form>
@endsection

@push('styles')
  @include('layouts.admin.partials.richtexteditor-styles')
@endpush

@push('scripts')
  @include('layouts.admin.partials.richtexteditor-scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      SuaveAdmin.initRichTextEditor('#blog-content', {
        height: 460,
        toolbar: 'blog',
        placeholder: 'Write your blog content…',
      });
    });
  </script>
@endpush
