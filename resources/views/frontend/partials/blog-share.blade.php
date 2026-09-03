@php
    $shareLinks = $shareLinks ?? [];
    $url = $url ?? '';
@endphp

<div class="blog-share" data-blog-share>
  <ul class="blog-share__list" id="blog-share-menu">
    @foreach ($shareLinks as $share)
      <li>
        <a class="blog-share__btn" href="{{ $share['href'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $share['label'] }}">
          {!! $share['icon'] !!}
        </a>
      </li>
    @endforeach
    <li>
      <button type="button" class="blog-share__btn" data-blog-share-copy data-url="{{ $url }}" aria-label="Copy link">
        <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
      </button>
    </li>
  </ul>
  <button
    type="button"
    class="blog-share__toggle"
    data-blog-share-toggle
    aria-expanded="false"
    aria-controls="blog-share-menu"
    aria-label="Share this article"
  >
    <svg class="blog-share__toggle-icon blog-share__toggle-icon--share" xmlns="https://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.59 13.51 15.42 17.49"/><path d="M15.41 6.51 8.59 10.49"/></svg>
    <svg class="blog-share__toggle-icon blog-share__toggle-icon--close" xmlns="https://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
  </button>
  <p class="blog-share__copied" data-blog-share-copied hidden>Link copied</p>
</div>
