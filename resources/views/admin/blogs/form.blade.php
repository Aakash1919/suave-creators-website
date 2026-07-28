@extends('layouts.admin')

@section('title', $blog->exists ? 'Edit blog' : 'New blog')

@section('content')
    <div class="admin-page-head">
        <div class="admin-page-head__copy">
            <h1 class="admin-page-title">{{ $blog->exists ? 'Edit blog' : 'New blog' }}</h1>
            <p class="admin-page-desc">Write the story first. Publishing and SEO live in the side panel.</p>
        </div>
        <div class="admin-page-head__actions">

            @if ($blog->exists)
                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" rel="noopener"
                    class="admin-btn admin-btn--secondary">
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                    View live
                </a>
            @endif
            <a href="{{ route('admin.blogs.index') }}" class="admin-btn admin-btn--secondary">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                Back to list
            </a>
        </div>
    </div>

    <form method="POST" action="{{ $blog->exists ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}"
        enctype="multipart/form-data" class="admin-blog-form" data-ajax-form
        data-success-message="{{ $blog->exists ? 'Blog has been updated successfully.' : 'Blog has been created successfully.' }}">
        @csrf
        @if ($blog->exists)
            @method('PUT')
        @endif

        <div class="admin-blog-form__layout">
            <div class="admin-blog-form__main">
                <section class="admin-card admin-blog-form__composer">
                    <div class="admin-card__body space-y-5">
                        <div>
                            <label class="admin-label" for="blog-title">Title</label>
                            <input id="blog-title" type="text" name="title" value="{{ old('title', $blog->title) }}"
                                required class="admin-input admin-input--lg" placeholder="Give this post a clear headline">
                        </div>

                        <div>
                            <label class="admin-label" for="blog-short-description">Short description</label>
                            <textarea id="blog-short-description" name="short_description" rows="3" class="admin-textarea"
                                placeholder="One or two sentences for cards and previews">{{ old('short_description', $blog->short_description) }}</textarea>
                        </div>

                        <div class="admin-rte admin-rte--blog">
                            <label class="admin-label" for="blog-content">Content</label>
                            <textarea id="blog-content" name="content" rows="18" class="admin-textarea">{{ old('content', $blog->content) }}</textarea>
                        </div>
                    </div>
                </section>

                <details class="admin-card admin-blog-form__seo" data-details-persist open>
                    <summary class="admin-blog-form__seo-summary">
                        <div>
                            <h2 class="admin-card__title">SEO & structured data</h2>
                            <p>Meta tags, Open Graph, and FAQs.</p>
                        </div>
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </summary>
                    <div class="admin-card__body space-y-5">
                        <div class="admin-form-grid admin-form-grid--2">
                            <div>
                                <label class="admin-label" for="blog-meta-title">Meta title</label>
                                <input id="blog-meta-title" type="text" name="meta_title"
                                    value="{{ old('meta_title', $blog->meta_title) }}" class="admin-input">
                            </div>
                            <div>
                                <label class="admin-label" for="blog-og-title">OG title</label>
                                <input id="blog-og-title" type="text" name="og_title"
                                    value="{{ old('og_title', $blog->og_title) }}" class="admin-input">
                            </div>
                            <div>
                                <label class="admin-label" for="blog-meta-description">Meta description</label>
                                <textarea id="blog-meta-description" name="meta_description" rows="3" class="admin-textarea">{{ old('meta_description', $blog->meta_description) }}</textarea>
                            </div>
                            <div>
                                <label class="admin-label" for="blog-og-description">OG description</label>
                                <textarea id="blog-og-description" name="og_description" rows="3" class="admin-textarea">{{ old('og_description', $blog->og_description) }}</textarea>
                            </div>
                        </div>

                        @php
                            $faqItems = old('faqs', is_array($blog->faqs) ? $blog->faqs : []);
                            $faqItems = is_array($faqItems) ? array_values($faqItems) : [];
                        @endphp

                        {{--
              TOC repeater disabled until frontend single-blog uses it.
              Re-enable with BlogService toc validation + normalizeTocItems().

            @php
              $tocItems = old('toc', is_array($blog->toc) ? $blog->toc : []);
              $tocItems = is_array($tocItems) ? array_values($tocItems) : [];
            @endphp
            <div class="admin-repeater" data-admin-repeater data-name="toc">
              <div class="admin-repeater__head">
                <div>
                  <h3 class="admin-repeater__title">Table of contents</h3>
                  <p class="admin-repeater__hint">Label + section anchor id (matches heading id in content). Every added row is required.</p>
                </div>
                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-repeater-add>
                  <i class="fa-solid fa-plus" aria-hidden="true"></i>
                  Add item
                </button>
              </div>
              <div class="admin-repeater__list" data-repeater-list>
                <p class="admin-repeater__empty" data-repeater-empty>No TOC items yet. Click Add item to create one.</p>
                @foreach ($tocItems as $index => $item)
                  <div class="admin-repeater__row" data-repeater-row>
                    <div class="admin-repeater__fields admin-repeater__fields--toc">
                      <div>
                        <label class="admin-label">Label</label>
                        <input type="text" name="toc[{{ $index }}][label]" value="{{ $item['label'] ?? '' }}" class="admin-input" data-repeater-toc-label placeholder="Section title" required>
                      </div>
                      <div>
                        <label class="admin-label">Anchor ID</label>
                        <input type="text" name="toc[{{ $index }}][anchor_id]" value="{{ $item['anchor_id'] ?? $item['id'] ?? '' }}" class="admin-input font-mono text-sm" data-repeater-toc-anchor placeholder="section-id" required pattern="[A-Za-z0-9_-]+">
                      </div>
                    </div>
                    <button type="button" class="admin-repeater__remove" data-repeater-remove aria-label="Remove TOC item">
                      <i class="fa-solid fa-trash" aria-hidden="true"></i>
                    </button>
                  </div>
                @endforeach
              </div>
              <template data-repeater-template>
                <div class="admin-repeater__row" data-repeater-row>
                  <div class="admin-repeater__fields admin-repeater__fields--toc">
                    <div>
                      <label class="admin-label">Label</label>
                      <input type="text" name="toc[__INDEX__][label]" value="" class="admin-input" data-repeater-toc-label placeholder="Section title" required>
                    </div>
                    <div>
                      <label class="admin-label">Anchor ID</label>
                      <input type="text" name="toc[__INDEX__][anchor_id]" value="" class="admin-input font-mono text-sm" data-repeater-toc-anchor placeholder="section-id" required pattern="[A-Za-z0-9_-]+">
                    </div>
                  </div>
                  <button type="button" class="admin-repeater__remove" data-repeater-remove aria-label="Remove TOC item">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                  </button>
                </div>
              </template>
            </div>
            --}}

                        <div class="admin-repeater" data-admin-repeater data-name="faqs">
                            <div class="admin-repeater__head">
                                <div>
                                    <h3 class="admin-repeater__title">FAQs</h3>
                                    <p class="admin-repeater__hint">Question and answer pairs for the FAQ section / schema.
                                        Every added row is required.</p>
                                </div>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm"
                                    data-repeater-add>
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                    Add FAQ
                                </button>
                            </div>
                            <div class="admin-repeater__list" data-repeater-list>
                                <p class="admin-repeater__empty" data-repeater-empty
                                    @if (count($faqItems) > 0) hidden @endif>No FAQs yet. Click “Add FAQ” to create
                                    one.</p>
                                @foreach ($faqItems as $index => $item)
                                    <div class="admin-repeater__row" data-repeater-row>
                                        <div class="admin-repeater__fields admin-repeater__fields--faq">
                                            <div>
                                                <label class="admin-label">Question</label>
                                                <input type="text" name="faqs[{{ $index }}][question]"
                                                    value="{{ $item['question'] ?? '' }}" class="admin-input"
                                                    placeholder="What do readers usually ask?" required>
                                            </div>
                                            <div>
                                                <label class="admin-label">Answer</label>
                                                <textarea name="faqs[{{ $index }}][answer]" rows="3" class="admin-textarea"
                                                    placeholder="Clear, helpful answer" required>{{ $item['answer'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <button type="button" class="admin-repeater__remove" data-repeater-remove
                                            aria-label="Remove FAQ">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <template data-repeater-template>
                                <div class="admin-repeater__row" data-repeater-row>
                                    <div class="admin-repeater__fields admin-repeater__fields--faq">
                                        <div>
                                            <label class="admin-label">Question</label>
                                            <input type="text" name="faqs[__INDEX__][question]" value=""
                                                class="admin-input" placeholder="What do readers usually ask?" required>
                                        </div>
                                        <div>
                                            <label class="admin-label">Answer</label>
                                            <textarea name="faqs[__INDEX__][answer]" rows="3" class="admin-textarea" placeholder="Clear, helpful answer"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <button type="button" class="admin-repeater__remove" data-repeater-remove
                                        aria-label="Remove FAQ">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </details>
            </div>

            <aside class="admin-blog-form__side">
                <section class="admin-card admin-blog-form__side-card">
                    <div class="admin-card__header">
                        <div>
                            <h2 class="admin-card__title">Publish</h2>
                            <p>Status, schedule, and taxonomy.</p>
                        </div>
                    </div>
                    <div class="admin-card__body space-y-4">
                        <div>
                            <label class="admin-label" for="blog-status">Status</label>
                            <select id="blog-status" name="status" class="admin-select">
                                <option value="draft" @selected(old('status', $blog->status) === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $blog->status) === 'published')>Published</option>
                            </select>
                        </div>
                        <div>
                            <label class="admin-label" for="blog-published-at">Published at</label>
                            <input id="blog-published-at" type="text" name="published_at"
                                value="{{ old('published_at', optional($blog->published_at)->format('Y-m-d H:i')) }}"
                                class="admin-input" placeholder="Select date & time" data-flatpickr
                                data-flatpickr-enable-time="true" data-flatpickr-date-format="Y-m-d H:i"
                                autocomplete="off">
                        </div>
                        <div>
                            <label class="admin-label" for="blog-category">Category</label>
                            <select id="blog-category" name="blog_category_id" class="admin-select">
                                <option value="">None</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) old('blog_category_id', $blog->blog_category_id) === (string) $category->id)>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="admin-label" for="blog-slug">Slug</label>
                            <input id="blog-slug" type="text" name="slug" value="{{ old('slug', $blog->slug) }}"
                                class="admin-input" placeholder="Auto from title if empty">
                        </div>
                    </div>
                </section>

                <section class="admin-card admin-blog-form__side-card">
                    <div class="admin-card__header">
                        <div>
                            <h2 class="admin-card__title">Featured image</h2>
                            <p>Shown on cards and social previews.</p>
                        </div>
                    </div>
                    <div class="admin-card__body">
                        <label class="admin-blog-form__image" for="blog-featured-image">
                            @if ($blog->featuredImageUrl())
                                <img src="{{ $blog->featuredImageUrl() }}" alt="Current featured image"
                                    title="Current featured image" class="admin-blog-form__image-preview">
                            @else
                                <span class="admin-blog-form__image-placeholder">
                                    <i class="fa-regular fa-image" aria-hidden="true"></i>
                                    Upload a featured image
                                </span>
                            @endif
                            <input id="blog-featured-image" type="file" name="featured_image" accept="image/*"
                                class="admin-blog-form__image-input">
                        </label>
                    </div>
                </section>

                <div class="admin-blog-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        {{ $blog->exists ? 'Save changes' : 'Create blog' }}
                    </button>
                    @if ($blog->exists && Auth::user()->hasPermission('blogs.delete'))
                        <button type="button" class="admin-btn admin-btn--danger admin-btn--block" data-admin-delete
                            data-url="{{ route('admin.blogs.destroy', $blog) }}"
                            data-confirm="Are you sure want to delete blog {{ $blog->title }}?"
                            data-confirm-title="Delete blog?" data-confirm-label="Delete"
                            data-success-message="Blog has been deleted successfully." data-reload-table="">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                            Delete
                        </button>
                    @endif
                </div>
            </aside>
        </div>
    </form>
@endsection

@push('styles')
    @include('layouts.admin.partials.richtexteditor-styles')
@endpush

@push('scripts')
    @include('layouts.admin.partials.richtexteditor-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            SuaveAdmin.initRichTextEditor('#blog-content', {
                height: 640,
                toolbar: 'blog',
                placeholder: 'Write your blog content…',
            });

            SuaveAdmin.bindRepeaters(document.querySelector('.admin-blog-form'));

            const imageInput = document.getElementById('blog-featured-image');
            const imageLabel = imageInput?.closest('.admin-blog-form__image');
            imageInput?.addEventListener('change', function() {
                const file = this.files && this.files[0];
                if (!file || !imageLabel) {
                    return;
                }
                const url = URL.createObjectURL(file);
                let img = imageLabel.querySelector('img.admin-blog-form__image-preview');
                if (!img) {
                    imageLabel.querySelector('.admin-blog-form__image-placeholder')?.remove();
                    img = document.createElement('img');
                    img.className = 'admin-blog-form__image-preview';
                    img.alt = 'Selected featured image';
                    img.title = 'Selected featured image';
                    imageLabel.insertBefore(img, this);
                }
                img.src = url;
            });
        });
    </script>
@endpush
