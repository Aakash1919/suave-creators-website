<a href="{{ $resolvedHref }}" {{ $attributes->class([$btnClass]) }}>
  {{ $slot }}
  @if ($showArrow)
    <x-frontend.cta-arrow />
  @endif
</a>
