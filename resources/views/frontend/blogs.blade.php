@extends('layouts.frontend')

@section('content')
<section class="blogs-hero relative z-10 w-full pb-8 pt-6 md:pb-10 md:pt-8 lg:pb-12 lg:pt-10 site-container">
  <div class="mx-auto max-w-[900px] text-center">
    <p class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-sm font-bold uppercase tracking-wide text-transparent pragati-narrow-regular">Blogs &amp; Insights</p>
    <h1 class="mt-2 text-[34px] font-semibold leading-[1.15] text-white min-[375px]:text-[40px] sm:text-5xl lg:text-[52px]">
      @if (! empty($activeCategory))
        {{ $activeCategory['name'] }}
        <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text pb-1 font-extrabold text-transparent">Articles</span>
      @else
        Ideas, Strategy &amp; <span class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text pb-1 font-extrabold text-transparent">Engineering Insights</span>
      @endif
    </h1>
    <p class="mt-4 text-sm leading-6 text-[#B1B9DF]">
      @if (! empty($activeCategory))
        Practical {{ strtolower($activeCategory['name']) }} articles from Suave Creators — strategies and engineering notes to help you build better software.
      @else
        Practical articles from our team on digital strategy, product growth, AI, startups, and design — written to help you build better software.
      @endif
    </p>
  </div>

  <div class="blogs-hero__gallery" aria-label="Featured workspace imagery">
    @foreach ($heroImages as $image)
      <figure class="blogs-hero__frame blogs-hero__frame--{{ $image['size'] }}">
        <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" title="{{ $image['alt'] }}" width="440" height="560" loading="eager" decoding="async">
      </figure>
    @endforeach
  </div>
</section>

<section class="full-bleed bg-white bg-cover bg-top bg-no-repeat py-16 lg:py-20" aria-label="All blog posts"
  style="background-image: url('{{ asset('assets/background/blog-section-bg.png') }}');"
  data-blog-listing
  data-filter-url="{{ route('blogs.filter') }}"
  data-blogs-url="{{ route('blogs') }}">
  <div class="section-inner">
    <form class="blog-filters" role="search" aria-label="Filter blog posts" data-blog-filters>
      <label class="blog-filters__search">
        <span class="sr-only">Search by title</span>
        <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="11" cy="11" r="8" />
          <path d="m21 21-4.3-4.3" />
        </svg>
        <input type="search" name="q" value="{{ $search ?? '' }}" placeholder="Search by title…"
          autocomplete="off" data-blog-search>
      </label>

      <label class="blog-filters__category">
        <span class="sr-only">Filter by category</span>
        <select name="category" data-blog-category-select>
          <option value="">All categories</option>
          @foreach ($categories as $category)
            <option value="{{ $category['slug'] }}" @selected(! empty($activeCategory) && $activeCategory['slug'] === $category['slug'])>
              {{ $category['name'] }} ({{ $category['count'] }})
            </option>
          @endforeach
        </select>
      </label>
    </form>

    <div class="blog-results" data-blog-results aria-live="polite">
      @include('frontend.partials.blog-posts', [
        'posts' => $posts,
        'paginator' => $paginator,
        'activeCategory' => $activeCategory ?? null,
        'search' => $search ?? '',
      ])
    </div>
  </div>
</section>

<x-frontend.consultation-section
  title="Have an Idea? Let's Turn It<br class=&quot;hidden sm:block&quot;> Into a Digital Product"
  description="Whatever stage your business is at, our team is ready to help you plan, design, and build the right solution."
  cta-label="Get a Free Quote"
/>
@endsection

@push('scripts')
<script>
(function () {
  var root = document.querySelector('[data-blog-listing]');
  if (!root) return;

  var filterUrl = root.getAttribute('data-filter-url');
  var blogsUrl = root.getAttribute('data-blogs-url');
  var results = root.querySelector('[data-blog-results]');
  var searchInput = root.querySelector('[data-blog-search]');
  var categorySelect = root.querySelector('[data-blog-category-select]');
  var debounceTimer = null;
  var activeRequest = null;
  var currentPage = 1;

  function currentParams(page) {
    var params = new URLSearchParams();
    var q = (searchInput && searchInput.value ? searchInput.value.trim() : '');
    var category = (categorySelect && categorySelect.value) || '';
    if (q) params.set('q', q);
    if (category) params.set('category', category);
    if (page && page > 1) params.set('page', String(page));
    return params;
  }

  function updateHistory(params) {
    var query = params.toString();
    var nextUrl = blogsUrl + (query ? ('?' + query) : '');
    window.history.replaceState({}, '', nextUrl);
  }

  function setLoading(isLoading) {
    root.classList.toggle('is-loading', !!isLoading);
    if (results) results.setAttribute('aria-busy', isLoading ? 'true' : 'false');
  }

  function fetchResults(page) {
    currentPage = page || 1;
    var params = currentParams(currentPage);
    updateHistory(params);

    if (activeRequest && typeof activeRequest.abort === 'function') {
      activeRequest.abort();
    }

    var controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
    activeRequest = controller;

    setLoading(true);

    var url = filterUrl + (params.toString() ? ('?' + params.toString()) : '');

    fetch(url, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      signal: controller ? controller.signal : undefined
    })
      .then(function (response) {
        if (!response.ok) throw new Error('Filter request failed');
        return response.json();
      })
      .then(function (data) {
        if (results && typeof data.html === 'string') {
          results.innerHTML = data.html;
        }
      })
      .catch(function (error) {
        if (error && error.name === 'AbortError') return;
        console.error(error);
      })
      .finally(function () {
        if (activeRequest === controller) {
          activeRequest = null;
          setLoading(false);
        }
      });
  }

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(function () {
        fetchResults(1);
      }, 300);
    });
  }

  if (categorySelect) {
    categorySelect.addEventListener('change', function () {
      fetchResults(1);
    });
  }

  root.addEventListener('click', function (event) {
    var pageLink = event.target.closest('[data-blog-page]');
    if (pageLink) {
      event.preventDefault();
      var page = parseInt(pageLink.getAttribute('data-blog-page'), 10) || 1;
      fetchResults(page);
      results.scrollIntoView({ behavior: 'smooth', block: 'start' });
      return;
    }

    var categoryLink = event.target.closest('[data-blog-category]');
    if (categoryLink && categorySelect) {
      event.preventDefault();
      categorySelect.value = categoryLink.getAttribute('data-blog-category') || '';
      fetchResults(1);
      return;
    }

    var clearBtn = event.target.closest('[data-blog-clear-filters]');
    if (clearBtn) {
      event.preventDefault();
      if (searchInput) searchInput.value = '';
      if (categorySelect) categorySelect.value = '';
      fetchResults(1);
    }
  });

  var form = root.querySelector('[data-blog-filters]');
  if (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      fetchResults(1);
    });
  }
})();
</script>
@endpush
