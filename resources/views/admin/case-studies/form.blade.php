@php
  $defaults = $defaultSections;
  $savedSections = old('sections', is_array($caseStudy->sections) ? $caseStudy->sections : []);
  $savedSections = is_array($savedSections) ? array_values($savedSections) : [];
  $sectionSlots = [];
  for ($i = 0; $i < 2; $i++) {
      $sectionSlots[$i] = array_merge($defaults[$i], is_array($savedSections[$i] ?? null) ? $savedSections[$i] : []);
      $points = $sectionSlots[$i]['points'] ?? [];
      $sectionSlots[$i]['points'] = array_values(array_filter(
          is_array($points) ? $points : [],
          static fn ($point): bool => trim((string) $point) !== ''
      ));
  }

  $resultItems = old('results', is_array($caseStudy->results) ? $caseStudy->results : []);
  $resultItems = is_array($resultItems) ? array_values($resultItems) : [];

  $technologiesValue = old('technologies');
  if ($technologiesValue === null) {
      $technologiesValue = implode(', ', is_array($caseStudy->technologies) ? $caseStudy->technologies : []);
  }

  $selectedServiceSlugs = old('service_slugs', is_array($caseStudy->service_slugs) ? $caseStudy->service_slugs : []);
  $selectedServiceSlugs = is_array($selectedServiceSlugs) ? array_map('strval', $selectedServiceSlugs) : [];
  $selectedIndustrySlugs = old('industry_slugs', is_array($caseStudy->industry_slugs) ? $caseStudy->industry_slugs : []);
  $selectedIndustrySlugs = is_array($selectedIndustrySlugs) ? array_map('strval', $selectedIndustrySlugs) : [];
  $serviceOptions = $serviceOptions ?? [];
  $industryOptions = $industryOptions ?? [];

  $visualLabels = [
      'discovery' => 'Discovery (map / search)',
      'preparation' => 'Preparation (document / AI)',
      'pipeline' => 'Pipeline (stages / board)',
  ];
@endphp

@extends('layouts.admin')

@section('title', $caseStudy->exists ? 'Edit case study' : 'New case study')

@section('content')
    <div class="admin-page-head">
        <div class="admin-page-head__copy">
            <h1 class="admin-page-title">{{ $caseStudy->exists ? 'Edit case study' : 'New case study' }}</h1>
            <p class="admin-page-desc">The public page layout is fixed. Fill the fields below — case studies are never auto-generated.</p>
        </div>
        <div class="admin-page-head__actions">
            @if ($caseStudy->exists)
                <a href="{{ route('case-study.show', $caseStudy->slug) }}" target="_blank" rel="noopener"
                    class="admin-btn admin-btn--secondary">
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                    View live
                </a>
            @endif
            <a href="{{ route('admin.case-studies.index') }}" class="admin-btn admin-btn--secondary">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                Back to list
            </a>
        </div>
    </div>

    <form method="POST"
        action="{{ $caseStudy->exists ? route('admin.case-studies.update', $caseStudy) : route('admin.case-studies.store') }}"
        enctype="multipart/form-data" class="admin-blog-form" data-ajax-form
        data-success-message="{{ $caseStudy->exists ? 'Case study has been updated successfully.' : 'Case study has been created successfully.' }}">
        @csrf
        @if ($caseStudy->exists)
            @method('PUT')
        @endif

        <div class="admin-blog-form__layout">
            <div class="admin-blog-form__main">
                <section class="admin-card admin-blog-form__composer">
                    <div class="admin-card__header">
                        <div>
                            <h2 class="admin-card__title">Listing &amp; hero</h2>
                            <p>Title, lead, and listing card copy.</p>
                        </div>
                    </div>
                    <div class="admin-card__body space-y-5">
                        <div>
                            <label class="admin-label" for="case-study-title">Title</label>
                            <input id="case-study-title" type="text" name="title"
                                value="{{ old('title', $caseStudy->title) }}" required
                                class="admin-input admin-input--lg" placeholder="Client — what you built">
                        </div>
                        <div>
                            <label class="admin-label" for="case-study-short-description">Short description</label>
                            <textarea id="case-study-short-description" name="short_description" rows="3" class="admin-textarea"
                                placeholder="Hero lead and listing card summary">{{ old('short_description', $caseStudy->short_description) }}</textarea>
                        </div>
                        <div>
                            <label class="admin-label" for="case-study-listing-subtitle">Listing subtitle</label>
                            <input id="case-study-listing-subtitle" type="text" name="listing_subtitle"
                                value="{{ old('listing_subtitle', $caseStudy->listing_subtitle) }}" class="admin-input"
                                placeholder="Short line under the title on the listing card">
                        </div>
                        <div class="admin-form-grid admin-form-grid--2">
                            <div>
                                <label class="admin-label" for="case-study-client">Client</label>
                                <input id="case-study-client" type="text" name="client"
                                    value="{{ old('client', $caseStudy->client) }}" class="admin-input"
                                    placeholder="Client or product name">
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-industry">Display industry</label>
                                <input id="case-study-industry" type="text" name="industry"
                                    value="{{ old('industry', $caseStudy->industry) }}" class="admin-input"
                                    placeholder="Hero eyebrow label (free text)">
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-year">Year</label>
                                <input id="case-study-year" type="text" name="year"
                                    value="{{ old('year', $caseStudy->year) }}" class="admin-input" placeholder="2026">
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-technologies">Listing tags</label>
                                <input id="case-study-technologies" type="text" name="technologies"
                                    value="{{ $technologiesValue }}" class="admin-input"
                                    placeholder="Comma-separated, e.g. Map discovery, AI briefings">
                            </div>
                        </div>
                        <div class="admin-form-grid admin-form-grid--2">
                            <div>
                                <span class="admin-label">Show on services</span>
                                <p class="admin-help">Select service pages that should feature this case study.</p>
                                <div class="admin-check-grid">
                                    @foreach ($serviceOptions as $slug => $label)
                                        <label class="admin-check">
                                            <input type="checkbox" name="service_slugs[]" value="{{ $slug }}"
                                                @checked(in_array($slug, $selectedServiceSlugs, true))>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <span class="admin-label">Show on industries</span>
                                <p class="admin-help">Select industry pages that should feature this case study.</p>
                                <div class="admin-check-grid">
                                    @foreach ($industryOptions as $slug => $label)
                                        <label class="admin-check">
                                            <input type="checkbox" name="industry_slugs[]" value="{{ $slug }}"
                                                @checked(in_array($slug, $selectedIndustrySlugs, true))>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="admin-card">
                    <div class="admin-card__body">
                        <div class="admin-repeater" data-admin-repeater data-name="results">
                            <div class="admin-repeater__head">
                                <div>
                                    <h3 class="admin-repeater__title">Key performance metrics</h3>
                                    <p class="admin-repeater__hint">Detail page shows all metrics. Listing cards use the first 3. Typically add 4. Every added row is required.</p>
                                </div>
                                <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-repeater-add>
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                    Add metric
                                </button>
                            </div>
                            <div class="admin-repeater__list" data-repeater-list>
                                <p class="admin-repeater__empty" data-repeater-empty @if (count($resultItems) > 0) hidden @endif>
                                    No metrics yet. Click “Add metric” to create one.
                                </p>
                                @foreach ($resultItems as $index => $item)
                                    <div class="admin-repeater__row" data-repeater-row>
                                        <div class="admin-repeater__fields admin-repeater__fields--toc">
                                            <div>
                                                <label class="admin-label">Value</label>
                                                <input type="text" name="results[{{ $index }}][value]"
                                                    value="{{ $item['value'] ?? '' }}" class="admin-input"
                                                    placeholder="~55%" required>
                                            </div>
                                            <div>
                                                <label class="admin-label">Label</label>
                                                <input type="text" name="results[{{ $index }}][label]"
                                                    value="{{ $item['label'] ?? '' }}" class="admin-input"
                                                    placeholder="What improved" required>
                                            </div>
                                        </div>
                                        <button type="button" class="admin-repeater__remove" data-repeater-remove
                                            aria-label="Remove metric">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <template data-repeater-template>
                                <div class="admin-repeater__row" data-repeater-row>
                                    <div class="admin-repeater__fields admin-repeater__fields--toc">
                                        <div>
                                            <label class="admin-label">Value</label>
                                            <input type="text" name="results[__INDEX__][value]" value=""
                                                class="admin-input" placeholder="~55%" required>
                                        </div>
                                        <div>
                                            <label class="admin-label">Label</label>
                                            <input type="text" name="results[__INDEX__][label]" value=""
                                                class="admin-input" placeholder="What improved" required>
                                        </div>
                                    </div>
                                    <button type="button" class="admin-repeater__remove" data-repeater-remove
                                        aria-label="Remove metric">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </section>

                <section class="admin-card">
                    <div class="admin-card__header">
                        <div>
                            <h2 class="admin-card__title">Overview</h2>
                            <p>Challenge, solution, and outcome — three cards on the public page.</p>
                        </div>
                    </div>
                    <div class="admin-card__body space-y-5">
                        <div>
                            <label class="admin-label" for="case-study-challenge">Challenge</label>
                            <textarea id="case-study-challenge" name="challenge" rows="5" class="admin-textarea"
                                placeholder="The problem the client faced">{{ old('challenge', $caseStudy->challenge) }}</textarea>
                        </div>
                        <div>
                            <label class="admin-label" for="case-study-solution">Solution</label>
                            <textarea id="case-study-solution" name="solution" rows="5" class="admin-textarea"
                                placeholder="What you built and how it works">{{ old('solution', $caseStudy->solution) }}</textarea>
                        </div>
                        <div>
                            <label class="admin-label" for="case-study-outcome">Outcome</label>
                            <textarea id="case-study-outcome" name="outcome" rows="5" class="admin-textarea"
                                placeholder="What changed after launch">{{ old('outcome', $caseStudy->outcome) }}</textarea>
                        </div>
                    </div>
                </section>

                @foreach ($sectionSlots as $index => $section)
                    <section class="admin-card">
                        <div class="admin-card__header">
                            <div>
                                <h2 class="admin-card__title">Story section {{ $index + 1 }}</h2>
                                <p>{{ $index === 0 ? 'First split block (visual on the right by default).' : 'Second split block (visual on the left by default).' }}</p>
                            </div>
                        </div>
                        <div class="admin-card__body space-y-5">
                            <div class="admin-form-grid admin-form-grid--2">
                                <div>
                                    <label class="admin-label" for="case-study-section-{{ $index }}-side">Visual side</label>
                                    <select id="case-study-section-{{ $index }}-side"
                                        name="sections[{{ $index }}][image_side]" class="admin-select">
                                        <option value="right" @selected(($section['image_side'] ?? 'right') === 'right')>Right</option>
                                        <option value="left" @selected(($section['image_side'] ?? '') === 'left')>Left</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="admin-label" for="case-study-section-{{ $index }}-visual">Fallback decorative visual</label>
                                    <select id="case-study-section-{{ $index }}-visual"
                                        name="sections[{{ $index }}][visual]" class="admin-select">
                                        @foreach ($visualLabels as $value => $label)
                                            <option value="{{ $value }}" @selected(($section['visual'] ?? '') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php
                                $sectionImagePath = (string) ($section['image'] ?? '');
                                $sectionImageUrl = $sectionImagePath !== '' ? $caseStudy->imageUrl($sectionImagePath) : null;
                            @endphp
                            <div>
                                <label class="admin-label" for="case-study-section-{{ $index }}-image">Visual image</label>
                                <p class="admin-repeater__hint" style="margin-bottom:0.65rem">Shown on the {{ ($section['image_side'] ?? 'right') === 'left' ? 'left' : 'right' }} of the copy. If you upload an image, it replaces the decorative graphic.</p>
                                <input type="hidden" name="sections[{{ $index }}][existing_image]" value="{{ $sectionImagePath }}">
                                <label class="admin-blog-form__image" for="case-study-section-{{ $index }}-image">
                                    @if ($sectionImageUrl)
                                        <img src="{{ $sectionImageUrl }}" alt="Current story section visual image"
                                            title="Current story section visual image" class="admin-blog-form__image-preview">
                                    @else
                                        <span class="admin-blog-form__image-placeholder">
                                            <i class="fa-regular fa-image" aria-hidden="true"></i>
                                            Upload a left/right visual image
                                        </span>
                                    @endif
                                    <input id="case-study-section-{{ $index }}-image" type="file"
                                        name="sections[{{ $index }}][image]" accept="image/*"
                                        class="admin-blog-form__image-input" data-section-image>
                                </label>
                                @if ($sectionImageUrl)
                                    <label class="admin-check" style="margin-top:0.75rem">
                                        <input type="checkbox" name="sections[{{ $index }}][remove_image]" value="1">
                                        Remove visual image
                                    </label>
                                @endif
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-section-{{ $index }}-eyebrow">Eyebrow</label>
                                <input id="case-study-section-{{ $index }}-eyebrow" type="text"
                                    name="sections[{{ $index }}][eyebrow]"
                                    value="{{ $section['eyebrow'] ?? '' }}" class="admin-input"
                                    placeholder="Practice, Discovery, …">
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-section-{{ $index }}-title">Section title</label>
                                <input id="case-study-section-{{ $index }}-title" type="text"
                                    name="sections[{{ $index }}][title]" value="{{ $section['title'] ?? '' }}"
                                    class="admin-input" placeholder="Headline for this split">
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-section-{{ $index }}-body">Body</label>
                                <textarea id="case-study-section-{{ $index }}-body" name="sections[{{ $index }}][body]" rows="4"
                                    class="admin-textarea" placeholder="One or two paragraphs">{{ $section['body'] ?? '' }}</textarea>
                            </div>
                            <div class="admin-repeater" data-admin-repeater data-name="sections[{{ $index }}][points]">
                                <div class="admin-repeater__head">
                                    <div>
                                        <h3 class="admin-repeater__title">Numbered points</h3>
                                        <p class="admin-repeater__hint">Shown as the numbered list on the public page. Add as many as you need. Every added row is required.</p>
                                    </div>
                                    <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-repeater-add>
                                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                        Add point
                                    </button>
                                </div>
                                <div class="admin-repeater__list" data-repeater-list>
                                    @php $pointItems = array_values($section['points'] ?? []); @endphp
                                    <p class="admin-repeater__empty" data-repeater-empty @if (count($pointItems) > 0) hidden @endif>
                                        No points yet. Click “Add point” to create one.
                                    </p>
                                    @foreach ($pointItems as $pointIndex => $point)
                                        <div class="admin-repeater__row" data-repeater-row>
                                            <div class="admin-repeater__fields">
                                                <div>
                                                    <label class="admin-label">Point</label>
                                                    <input type="text"
                                                        name="sections[{{ $index }}][points][{{ $pointIndex }}]"
                                                        value="{{ $point }}" class="admin-input"
                                                        placeholder="A concrete step or outcome" required>
                                                </div>
                                            </div>
                                            <button type="button" class="admin-repeater__remove" data-repeater-remove
                                                aria-label="Remove point">
                                                <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <template data-repeater-template>
                                    <div class="admin-repeater__row" data-repeater-row>
                                        <div class="admin-repeater__fields">
                                            <div>
                                                <label class="admin-label">Point</label>
                                                <input type="text" name="sections[{{ $index }}][points][__INDEX__]"
                                                    value="" class="admin-input"
                                                    placeholder="A concrete step or outcome" required>
                                            </div>
                                        </div>
                                        <button type="button" class="admin-repeater__remove" data-repeater-remove
                                            aria-label="Remove point">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </section>
                @endforeach

                <details class="admin-card admin-blog-form__seo" data-details-persist open>
                    <summary class="admin-blog-form__seo-summary">
                        <div>
                            <h2 class="admin-card__title">SEO</h2>
                            <p>Optional meta and Open Graph.</p>
                        </div>
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </summary>
                    <div class="admin-card__body space-y-5">
                        @if ($caseStudy->exists)
                            <div class="admin-blog-form__seo-toolbar">
                                <p class="admin-blog-form__seo-hint">Generate suggestions from the current title, short description, and overview. Nothing is saved until you click Save changes.</p>
                                <button type="button" id="case-study-generate-seo" class="admin-btn admin-btn--secondary admin-btn--sm"
                                    data-url="{{ route('admin.case-studies.generate-seo', $caseStudy) }}"
                                    data-loading-text="Generating…">
                                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                                    Generate SEO meta
                                </button>
                            </div>
                        @endif
                        <div class="admin-form-grid admin-form-grid--2">
                            <div>
                                <label class="admin-label" for="case-study-meta-title">Meta title</label>
                                <input id="case-study-meta-title" type="text" name="meta_title"
                                    value="{{ old('meta_title', $caseStudy->meta_title) }}" class="admin-input">
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-og-title">OG title</label>
                                <input id="case-study-og-title" type="text" name="og_title"
                                    value="{{ old('og_title', $caseStudy->og_title) }}" class="admin-input">
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-meta-description">Meta description</label>
                                <textarea id="case-study-meta-description" name="meta_description" rows="3" class="admin-textarea">{{ old('meta_description', $caseStudy->meta_description) }}</textarea>
                            </div>
                            <div>
                                <label class="admin-label" for="case-study-og-description">OG description</label>
                                <textarea id="case-study-og-description" name="og_description" rows="3" class="admin-textarea">{{ old('og_description', $caseStudy->og_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </details>
            </div>

            <aside class="admin-blog-form__side">
                <section class="admin-card admin-blog-form__side-card">
                    <div class="admin-card__header">
                        <div>
                            <h2 class="admin-card__title">Publish</h2>
                            <p>Status, schedule, and listing order.</p>
                        </div>
                    </div>
                    <div class="admin-card__body space-y-4">
                        <div>
                            <label class="admin-label" for="case-study-status">Status</label>
                            <select id="case-study-status" name="status" class="admin-select">
                                <option value="draft" @selected(old('status', $caseStudy->status) === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $caseStudy->status) === 'published')>Published</option>
                            </select>
                        </div>
                        <div>
                            <label class="admin-label" for="case-study-published-at">Published at</label>
                            <input id="case-study-published-at" type="text" name="published_at"
                                value="{{ old('published_at', optional($caseStudy->published_at)->format('Y-m-d H:i')) }}"
                                class="admin-input" placeholder="Select date & time" data-flatpickr
                                data-flatpickr-enable-time="true" data-flatpickr-date-format="Y-m-d H:i"
                                autocomplete="off">
                        </div>
                        <div>
                            <label class="admin-label" for="case-study-sort-order">Listing order</label>
                            <input id="case-study-sort-order" type="number" name="sort_order" min="0" max="9999"
                                value="{{ old('sort_order', $caseStudy->sort_order) }}" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label" for="case-study-slug">Slug</label>
                            <input id="case-study-slug" type="text" name="slug"
                                value="{{ old('slug', $caseStudy->slug) }}" class="admin-input"
                                placeholder="Auto from title if empty">
                        </div>
                    </div>
                </section>

                <section class="admin-card admin-blog-form__side-card">
                    <div class="admin-card__header">
                        <div>
                            <h2 class="admin-card__title">Hero image</h2>
                            <p>Listing card and detail hero.</p>
                        </div>
                    </div>
                    <div class="admin-card__body">
                        <label class="admin-blog-form__image" for="case-study-featured-image">
                            @if ($caseStudy->featuredImageUrl())
                                <img src="{{ $caseStudy->featuredImageUrl() }}" alt="Current case study hero image"
                                    title="Current case study hero image" class="admin-blog-form__image-preview">
                            @else
                                <span class="admin-blog-form__image-placeholder">
                                    <i class="fa-regular fa-image" aria-hidden="true"></i>
                                    Upload a hero image
                                </span>
                            @endif
                            <input id="case-study-featured-image" type="file" name="featured_image" accept="image/*"
                                class="admin-blog-form__image-input">
                        </label>
                    </div>
                </section>

                <div class="admin-blog-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        {{ $caseStudy->exists ? 'Save changes' : 'Create case study' }}
                    </button>
                    @if ($caseStudy->exists && Auth::user()->hasPermission('case-studies.delete'))
                        <button type="button" class="admin-btn admin-btn--danger admin-btn--block" data-admin-delete
                            data-url="{{ route('admin.case-studies.destroy', $caseStudy) }}"
                            data-confirm="Are you sure want to delete case study {{ $caseStudy->title }}?"
                            data-confirm-title="Delete case study?" data-confirm-label="Delete"
                            data-success-message="Case study has been deleted successfully." data-reload-table="">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                            Delete
                        </button>
                    @endif
                </div>
            </aside>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            SuaveAdmin.bindRepeaters(document.querySelector('.admin-blog-form'));

            document.querySelectorAll('[data-section-image], #case-study-featured-image').forEach(function (imageInput) {
                const imageLabel = imageInput.closest('.admin-blog-form__image');
                imageInput.addEventListener('change', function () {
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
                        img.alt = 'Selected visual image';
                        img.title = 'Selected visual image';
                        imageLabel.insertBefore(img, this);
                    }
                    img.src = url;
                });
            });

            const generateSeoBtn = document.getElementById('case-study-generate-seo');
            generateSeoBtn?.addEventListener('click', function () {
                const btn = this;
                const url = btn.getAttribute('data-url');
                if (!url || btn.classList.contains('is-loading')) {
                    return;
                }

                const form = document.querySelector('.admin-blog-form');
                const title = document.getElementById('case-study-title')?.value?.trim() || '';
                if (!title) {
                    SuaveAdmin.createFlashMessage('error', 'Add a case study title before generating SEO meta.');
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
                            short_description: document.getElementById('case-study-short-description')?.value || '',
                            client: document.getElementById('case-study-client')?.value || '',
                            industry: document.getElementById('case-study-industry')?.value || '',
                            challenge: document.getElementById('case-study-challenge')?.value || '',
                            solution: document.getElementById('case-study-solution')?.value || '',
                            outcome: document.getElementById('case-study-outcome')?.value || '',
                        },
                    })
                    .done(function (response) {
                        const seo = response?.seo || {};
                        const fields = {
                            'case-study-meta-title': seo.meta_title,
                            'case-study-meta-description': seo.meta_description,
                            'case-study-og-title': seo.og_title,
                            'case-study-og-description': seo.og_description,
                        };
                        Object.keys(fields).forEach(function (id) {
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
                    .fail(function (xhr) {
                        SuaveAdmin.toast.validation(xhr, 'Unable to generate SEO meta.');
                    })
                    .always(function () {
                        btn.classList.remove('is-loading');
                        btn.disabled = false;
                        btn.removeAttribute('aria-busy');
                        btn.innerHTML = originalHtml;
                    });
            });
        });
    </script>
@endpush
