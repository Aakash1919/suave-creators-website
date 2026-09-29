@php
  $opensModal = $modal || $resolvedHref === '#contact-modal' || $attributes->has('data-open-contact-modal');
  $linkAttributes = $attributes->class([$btnClass]);
  if ($opensModal && ! $attributes->has('data-open-contact-modal')) {
      $linkAttributes = $linkAttributes->merge(['data-open-contact-modal' => true]);
  }
  if ($service !== '' && ! $attributes->has('data-service')) {
      $linkAttributes = $linkAttributes->merge(['data-service' => $service]);
  }
@endphp
<a href="{{ $resolvedHref }}"
  @if (str_starts_with($resolvedHref, 'http')) target="_blank" rel="noopener noreferrer" @endif
  {{ $linkAttributes }}>
  {{ $slot }}
  @if ($showArrow)
    <x-frontend.cta-arrow />
  @endif
</a>
