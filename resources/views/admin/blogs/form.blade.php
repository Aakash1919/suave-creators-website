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
        data-blog-content-css="{{ asset('css/admin-blog-content.css') }}"
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
                            <p class="admin-repeater__hint" style="margin: 0 0 0.55rem;">Insert a layout block, then edit it in the article. Undo / Redo reverse the last change. Remove block deletes the block the cursor is in. Completion-bar labels and percents are edited in the article, not the sidebar.</p>
                            <div class="admin-blog-blocks" data-blog-block-toolbar role="toolbar" aria-label="Blog editor actions">
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-editor="undo" title="Undo last change">Undo</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-editor="redo" title="Redo last change">Redo</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-editor="removeblock" title="Remove the layout block the cursor is in">Remove block</button>
                                <span class="admin-blog-blocks__split" aria-hidden="true"></span>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-block="inserttakeaways" title="Insert key takeaways">Takeaways</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-block="insertresults" title="Insert results list">Results</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-block="insertchecklist" title="Insert checklist">Checklist</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-block="insertstats" title="Insert stat boxes">Stat boxes</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-block="insertchart" title="Insert completion bars">Completion bars</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-block="insertinsight" title="Insert insight callout">Insight</button>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-blog-block="insertblogtable" title="Insert comparison table">Comparison table</button>
                            </div>
                            <textarea id="blog-content" name="content" rows="18" class="admin-textarea">{{ old('content', $editorContent ?? $blog->content) }}</textarea>
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
                        @if ($blog->exists)
                            <div class="admin-blog-form__seo-toolbar">
                                <p class="admin-blog-form__seo-hint">Generate suggestions from the current title, short description, and content. Nothing is saved until you click Save changes.</p>
                                <button type="button" id="blog-generate-seo" class="admin-btn admin-btn--secondary admin-btn--sm"
                                    data-url="{{ route('admin.blogs.generate-seo', $blog) }}"
                                    data-loading-text="Generating…">
                                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                                    Generate SEO meta
                                </button>
                            </div>
                        @endif
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
                            <p>Ready checklist, status, schedule, and taxonomy.</p>
                        </div>
                    </div>
                    <div class="admin-card__body space-y-4">
                        @php
                            $completeness = $completeness ?? ['percent' => 0, 'done' => 0, 'total' => 0, 'items' => []];
                        @endphp
                        <div class="admin-blog-complete" data-blog-completeness>
                            <div class="admin-blog-complete__bar" data-complete-bar role="progressbar"
                                aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ (int) $completeness['percent'] }}"
                                aria-label="Frontend completeness">
                                <span class="admin-blog-complete__fill" data-complete-fill
                                    style="width: {{ (int) $completeness['percent'] }}%"></span>
                            </div>
                            <p class="admin-blog-complete__meta" data-complete-meta>
                                <strong>{{ (int) $completeness['percent'] }}%</strong>
                                ready for the public blog page
                                ({{ (int) $completeness['done'] }} of {{ (int) $completeness['total'] }})
                            </p>
                            <ul class="admin-blog-complete__list">
                                @foreach ($completeness['items'] as $item)
                                    <li data-complete-key="{{ $item['key'] }}" @class(['is-done' => ! empty($item['done'])])>
                                        {{ $item['label'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

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
    <link rel="stylesheet" href="{{ asset('css/admin-blog-content.css') }}">
@endpush

@push('scripts')
    @include('layouts.admin.partials.richtexteditor-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            SuaveAdmin.initRichTextEditor('#blog-content', {
                height: 640,
                toolbar: 'blog',
                placeholder: 'Write your blog content…',
                wordCountGoal: 1800,
            });

            SuaveAdmin.bindRepeaters(document.querySelector('.admin-blog-form'));
            SuaveAdmin.initBlogEditForm(document);

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

            const generateSeoBtn = document.getElementById('blog-generate-seo');
            generateSeoBtn?.addEventListener('click', function() {
                const btn = this;
                const url = btn.getAttribute('data-url');
                if (!url || btn.classList.contains('is-loading')) {
                    return;
                }

                const form = document.querySelector('.admin-blog-form');
                if (form && window.SuaveAdmin?.syncRichTextEditors) {
                    SuaveAdmin.syncRichTextEditors(form);
                }

                const title = document.getElementById('blog-title')?.value?.trim() || '';
                if (!title) {
                    SuaveAdmin.createFlashMessage('error', 'Add a blog title before generating SEO meta.');
                    return;
                }

                const originalHtml = btn.innerHTML;
                const loadingText = btn.getAttribute('data-loading-text') || 'Generating…';
                btn.classList.add('is-loading');
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> ' + loadingText;

                SuaveAdmin.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                form?.querySelector('input[name="_token"]')?.value,
                            _ajax: 1,
                            title: title,
                            short_description: document.getElementById('blog-short-description')?.value || '',
                            content: document.getElementById('blog-content')?.value || '',
                        },
                    })
                    .done(function(response) {
                        const seo = response?.seo || {};
                        const fields = {
                            'blog-meta-title': seo.meta_title,
                            'blog-meta-description': seo.meta_description,
                            'blog-og-title': seo.og_title,
                            'blog-og-description': seo.og_description,
                        };
                        Object.keys(fields).forEach(function(id) {
                            const el = document.getElementById(id);
                            if (el && fields[id] != null) {
                                el.value = fields[id];
                            }
                        });
                        SuaveAdmin.createFlashMessage(
                            'success',
                            response?.message || 'SEO meta generated. Review the fields and save when ready.'
                        );
                    })
                    .fail(function(xhr) {
                        SuaveAdmin.toast.validation(xhr, 'Unable to generate SEO meta.');
                    })
                    .always(function() {
                        btn.classList.remove('is-loading');
                        btn.disabled = false;
                        btn.removeAttribute('aria-busy');
                        btn.innerHTML = originalHtml;
                    });
            });
        });
    </script>
@endpush
