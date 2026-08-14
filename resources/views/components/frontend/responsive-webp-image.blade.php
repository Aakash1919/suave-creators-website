@props([
    'src',
    'alt',
    'title' => null,
    'sizes' => '(min-width: 768px) 292px, 298px',
    'width' => null,
    'height' => null,
])

@php
    $title = filled($title) ? $title : $alt;
    $path = (string) $src;
    $isWebp = str_ends_with($path, '.webp');
    $imageBase = $isWebp ? preg_replace('/\.webp$/', '', $path) : null;
    $fullWidth = $width;
    $srcset = [];

    if ($isWebp && ($fullWidth === null || $height === null)) {
        $dimensions = @getimagesize(public_path($path));

        if (is_array($dimensions)) {
            $fullWidth = $fullWidth ?? $dimensions[0];
            $width = $width ?? $dimensions[0];
            $height = $height ?? $dimensions[1];
        }
    }

    $fallbackSrc = $path;

    if ($isWebp && filled($imageBase) && filled($fullWidth)) {
        foreach ([320, 480, 640] as $variantWidth) {
            $variantRelative = $imageBase.'-'.$variantWidth.'.webp';
            $variantPath = public_path($variantRelative);

            if (is_file($variantPath)) {
                $srcset[] = asset($variantRelative).' '.$variantWidth.'w';

                // Prefer the smallest variant as src fallback (not the largest).
                if ($fallbackSrc === $path) {
                    $fallbackSrc = $variantRelative;
                }
            }
        }

        $srcset[] = asset($path).' '.$fullWidth.'w';
    }
@endphp

<img
  src="{{ asset($fallbackSrc) }}"
  @if ($srcset !== [])
    srcset="{{ implode(', ', $srcset) }}"
    sizes="{{ $sizes }}"
  @endif
  alt="{{ $alt }}"
  title="{{ $title }}"
  @if ($width && $height) width="{{ $width }}" height="{{ $height }}" @endif
  {{ $attributes }}>
