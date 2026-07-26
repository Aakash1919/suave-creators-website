$ErrorActionPreference = 'Stop'
$design = 'D:\design\index.php'
$dest = 'D:\suave-creators\resources\views\frontend\home.blade.php'

$raw = [IO.File]::ReadAllText($design)
$raw = [regex]::Replace($raw, '(?s)^<\?php.*?require\s+__DIR__\s*\.\s*[''"]/layout/start\.php[''"]\s*;\s*\?>\s*', '')
$raw = [regex]::Replace($raw, '(?s)\s*<\?php\s*require\s+__DIR__\s*\.\s*[''"]/layout/end\.php[''"]\s*;\s*\?>\s*$', '')

# Component replacements
$raw = [regex]::Replace($raw, '(?s)<!-- Web Development Services Section Start -->.*?<!-- Web Development Services Section End -->', @"
<!-- Web Development Services Section Start -->
<x-frontend.three-card-section />
<!-- Web Development Services Section End -->
"@)

$raw = [regex]::Replace($raw, '(?s)<!-- Digital Services Marquee Section Start -->.*?<!-- Digital Services Marquee Section End -->', @"
<!-- Digital Services Marquee Section Start -->
<x-frontend.marquee-section
  type="text"
  direction="left"
  position="full"
  :items="`$servicesMarqueeItems"
  aria-label="Web Development, Promotion Marketing, Advertising, and CRM Development"
/>
<!-- Digital Services Marquee Section End -->
"@)

$raw = [regex]::Replace($raw, '(?s)<!-- Technology Section Start -->.*?<!-- Technology Section End -->', @"
<!-- Technology Section Start -->
<x-frontend.four-card-section />
<!-- Technology Section End -->
"@)

$raw = [regex]::Replace($raw, '(?s)<!-- FAQ Section Start -->.*?<!-- FAQ Section End -->', @"
<x-frontend.faq-section
  :qa="`$faqs"
  :media="`$faqMedia"
  :media-type="`$faqMediaType"
  :media-alt="`$faqMediaAlt"
  :cta-href="`$faqCtaHref"
  :cta-label="`$faqCtaLabel"
/>
"@)

$raw = [regex]::Replace($raw, '(?s)<\?php\s*require\s+__DIR__\s*\.\s*[''"]/partials/testimonials-section\.php[''"]\s*;\s*\?>', '<x-frontend.testimonials-section :items="$testimonials" />')

$raw = [regex]::Replace($raw, '(?s)<\?php\s*\$articlesInsightsItems\s*=\s*\[.*?\];\s*\$articlesInsightsHeadingId\s*=\s*[^;]+;\s*\$articlesInsightsMoreHref\s*=\s*[^;]+;\s*\$articlesInsightsMoreLabel\s*=\s*[^;]+;\s*require\s+__DIR__\s*\.\s*[''"]/partials/articles-insights\.php[''"]\s*;\s*\?>', @"
<x-frontend.articles-insights-section
  :items="`$articles"
  heading-id="articles-insights-title"
  more-href="/blogs"
  more-label="View More"
/>
"@)

$raw = [regex]::Replace($raw, '(?s)<div class="partnership-marquee"[^>]*>.*?</div>\s*(?=</div>\s*</section>\s*<!-- Partnerships Section End -->)', @"
    <x-frontend.marquee-section
      type="image"
      direction="left"
      position="contained"
      :items="`$partnerMarqueeItems"
      aria-label="Client logos"
      :speed="28"
    />
"@)

# PHP control structures before echoes
$raw = [regex]::Replace($raw, '<\?php\s+foreach\s*\((.+?)\)\s*:\s*\?>', '@foreach ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+endforeach;\s*\?>', '@endforeach')
$raw = [regex]::Replace($raw, '<\?php\s+for\s*\((.+?)\)\s*:\s*\?>', '@for ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+endfor;\s*\?>', '@endfor')
$raw = [regex]::Replace($raw, '<\?php\s+if\s*\((.+?)\)\s*:\s*\?>', '@if ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+elseif\s*\((.+?)\)\s*:\s*\?>', '@elseif ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+else\s*:\s*\?>', '@else')
$raw = [regex]::Replace($raw, '<\?php\s+endif;\s*\?>', '@endif')

$raw = [regex]::Replace($raw, '<\?=\s*htmlspecialchars\(\s*(.+?)\s*(?:,\s*ENT_QUOTES,\s*[''"]UTF-8[''"]\s*)?\)\s*\?>', '{{ $1 }}')
$raw = [regex]::Replace($raw, '<\?=\s*(.+?)\s*\?>', '{{ $1 }}')

$raw = [regex]::Replace($raw, '(?s)<\?php\s+(.*?)\s*\?>', {
  param($m)
  $body = $m.Groups[1].Value.Trim()
  if ($body -eq '') { return '' }
  if ($body -match 'layout/(start|end)|partials/') { return '' }
  return "@php`n$body`n@endphp"
})

# Design still uses flat /images/...; convert to asset() then remap via asset-path-map.json
$mapPath = Join-Path $PSScriptRoot 'asset-path-map.json'
$pathMap = @{}
if (Test-Path $mapPath) {
  $json = Get-Content -Raw -Path $mapPath | ConvertFrom-Json
  foreach ($prop in $json.PSObject.Properties) {
    if (-not $prop.Name.StartsWith('/')) {
      $pathMap[$prop.Name] = [string]$prop.Value
    }
  }
}

function Resolve-AssetPath([string]$relative) {
  $key = 'images/' + ($relative -replace '^/+', '')
  if ($pathMap.ContainsKey($key)) { return $pathMap[$key] }
  return $key
}

# bg-[url('/images/...')] -> style with asset()
$raw = [regex]::Replace($raw, "bg-\[url\('/images/([^']+)'\)\]", {
  param($m)
  $p = Resolve-AssetPath $m.Groups[1].Value
  "bg-cover bg-top bg-no-repeat`" style=`"background-image: url('{{ asset('$p') }}')"
})

# src="/images/..." -> asset
$raw = [regex]::Replace($raw, 'src="/images/([^"]+)"', {
  param($m)
  $p = Resolve-AssetPath $m.Groups[1].Value
  "src=`"{{ asset('$p') }}`""
})
$raw = [regex]::Replace($raw, "src='/images/([^']+)'", {
  param($m)
  $p = Resolve-AssetPath $m.Groups[1].Value
  "src=`"{{ asset('$p') }}`""
})

# style url('/images/')
$raw = [regex]::Replace($raw, "url\('/images/([^']+)'\)", {
  param($m)
  $p = Resolve-AssetPath $m.Groups[1].Value
  "url('{{ asset('$p') }}')"
})

# Add decoding/loading on plain img tags that lack them (best-effort for content imgs)
# Skip if already has decoding=
$raw = [regex]::Replace($raw, '(?s)<img(\s+)(?![^>]*decoding=)([^>]*?)(/?)>', {
  param($m)
  $attrs = $m.Groups[2].Value
  $close = $m.Groups[3].Value
  if ($attrs -notmatch 'decoding=') { $attrs += ' decoding="async"' }
  if ($attrs -notmatch 'alt=') { $attrs += ' alt=""' }
  if ($attrs -notmatch 'loading=' -and $attrs -notmatch 'fetchpriority=') { $attrs += ' loading="lazy"' }
  return "<img$($m.Groups[1].Value)$attrs$close>"
})

# Extract trailing style/script blocks for @push
$customCss = ''
$scripts = ''
if ($raw -match '(?s)(<style>.*?</style>)') {
  $customCss = $Matches[1]
  $raw = $raw.Replace($Matches[1], '')
}
# Collect script tags that are page-level (not already in components)
$scriptMatches = [regex]::Matches($raw, '(?s)<script(?![^>]*src=)[^>]*>.*?</script>')
if ($scriptMatches.Count -gt 0) {
  $scripts = ($scriptMatches | ForEach-Object { $_.Value }) -join "`n"
  foreach ($sm in $scriptMatches) { $raw = $raw.Replace($sm.Value, '') }
}

$out = @"
@extends('layouts.frontend')

@section('seo')
  <x-layouts.seo
    title="Suave Creators | Web & Software Development Solutions"
    description="We are a trusted Custom Software Development Company that specializes in CRM Development, Web Application, & Enterprise Software Solutions to help businesses grow."
    og-title="Suave Creators | Web & Software Development Solutions"
    og-description="Custom Software, CRM, Web Application & Enterprise Software Development Solutions."
    :canonical="url()->current()"
    :og-url="url()->current()"
  />
@endsection

@section('content')
$raw
@endsection
"@

if ($customCss) {
  $out += "`n@push('custom-css')`n$customCss`n@endpush`n"
}
if ($scripts) {
  $out += "`n@push('scripts')`n$scripts`n@endpush`n"
}

$utf8 = New-Object System.Text.UTF8Encoding $false
[IO.File]::WriteAllText($dest, $out, $utf8)
Write-Output "Wrote $dest ($($out.Length) chars)"
