<a href="{{ $resolvedHref }}"
  @if (str_starts_with($resolvedHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
  {{ $attributes->class([$btnClass]) }}>
  {{ $slot }}
  @if ($showArrow)
    <x-frontend.cta-arrow />
  @endif
</a>
