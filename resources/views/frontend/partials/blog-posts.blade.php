@if (count($posts) > 0)
  <div class="blog-grid">
    @foreach ($posts as $post)
      <article class="articles-card">
        <figure class="articles-card__image">
          <a href="{{ $post['url'] }}">
            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" title="{{ $post['title'] }}" width="480" height="280" loading="lazy">
          </a>
        </figure>
        <div class="articles-card__body">
          <div class="articles-card__meta">
            <span class="articles-card__byline">
              <svg xmlns="https://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 24 24" fill="none"
                stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <circle cx="12" cy="8" r="5" />
                <path d="M20 21a8 8 0 0 0-16 0" />
              </svg>
              {{ $post['author_name'] }}
            </span>
            <time datetime="{{ $post['published_date'] }}">
              <svg xmlns="https://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none"
                stroke="#85868C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M3 10h18" />
              </svg>
              {{ $post['published_label'] }}
            </time>
          </div>
          <h3><a href="{{ $post['url'] }}">{{ $post['title'] }}</a></h3>
          <p title="{{ $post['short_description'] }}">{{ $post['short_description'] }}</p>
          <div class="articles-card__footer">
            @if (! empty($post['category']))
              <a href="{{ $post['category_url'] }}" class="articles-card__category" data-blog-category="{{ $post['category_slug'] }}">{{ $post['category'] }}</a>
            @else
              <span></span>
            @endif
            <a class="articles-card__link group" href="{{ $post['url'] }}">
              Read more<span class="sr-only"> about {{ $post['title'] }}</span>
              <x-frontend.cta-arrow />
            </a>
          </div>
        </div>
      </article>
    @endforeach
  </div>

  @if (isset($paginator) && $paginator->hasPages())
    <nav class="blog-pagination" aria-label="Blog pagination">
      @if ($paginator->onFirstPage())
        <span class="blog-pagination__btn is-disabled" aria-disabled="true">Previous</span>
      @else
        <a class="blog-pagination__btn" href="{{ $paginator->previousPageUrl() }}" data-blog-page="{{ $paginator->currentPage() - 1 }}">Previous</a>
      @endif

      <ul class="blog-pagination__pages">
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
          <li>
            @if ($page == $paginator->currentPage())
              <span class="blog-pagination__page is-active" aria-current="page">{{ $page }}</span>
            @else
              <a class="blog-pagination__page" href="{{ $url }}" data-blog-page="{{ $page }}">{{ $page }}</a>
            @endif
          </li>
        @endforeach
      </ul>

      @if ($paginator->hasMorePages())
        <a class="blog-pagination__btn" href="{{ $paginator->nextPageUrl() }}" data-blog-page="{{ $paginator->currentPage() + 1 }}">Next</a>
      @else
        <span class="blog-pagination__btn is-disabled" aria-disabled="true">Next</span>
      @endif
    </nav>
  @endif
@else
  <div class="blog-empty">
    <p>
      No articles found
      @if (! empty($search))
        for “{{ $search }}”
      @endif
      @if (! empty($activeCategory))
        in {{ $activeCategory['name'] }}
      @endif
      yet.
    </p>
    <button type="button" class="mt-4 inline-flex text-sm font-semibold text-[#2A4DFB] underline" data-blog-clear-filters>
      Clear filters
    </button>
  </div>
@endif
