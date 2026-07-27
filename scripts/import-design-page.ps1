# Generic design PHP → Blade converter (strips layout, remaps assets, Blade-ifies PHP).
param(
  [Parameter(Mandatory = $true)][string]$Source,
  [Parameter(Mandatory = $true)][string]$Dest,
  [string]$SeoTitle = 'Suave Creators',
  [string]$SeoDescription = 'Suave Creators web and software development'
)

$ErrorActionPreference = 'Stop'
$raw = [IO.File]::ReadAllText($Source)

# Strip opening PHP through layout/start
$raw = [regex]::Replace($raw, '(?s)^<\?php.*?require\s+__DIR__\s*\.\s*[''"]/layout/start\.php[''"]\s*;\s*\?>\s*', '')
$raw = [regex]::Replace($raw, '(?s)\s*<\?php\s*require\s+__DIR__\s*\.\s*[''"]/layout/end\.php[''"]\s*;\s*\?>\s*$', '')

# PHP control structures
$raw = [regex]::Replace($raw, '<\?php\s+foreach\s*\((.+?)\)\s*:\s*\?>', '@foreach ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+endforeach;\s*\?>', '@endforeach')
$raw = [regex]::Replace($raw, '<\?php\s+for\s*\((.+?)\)\s*:\s*\?>', '@for ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+endfor;\s*\?>', '@endfor')
$raw = [regex]::Replace($raw, '<\?php\s+if\s*\((.+?)\)\s*:\s*\?>', '@if ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+elseif\s*\((.+?)\)\s*:\s*\?>', '@elseif ($1)')
$raw = [regex]::Replace($raw, '<\?php\s+else\s*:\s*\?>', '@else')
$raw = [regex]::Replace($raw, '<\?php\s+endif;\s*\?>', '@endif')

$raw = [regex]::Replace($raw, '<\?=\s*htmlspecialchars\(\s*(.+?)\s*(?:,\s*ENT_QUOTES,\s*[''"]UTF-8[''"]\s*)?\)\s*\?>', '{{ $1 }}')
$raw = [regex]::Replace($raw, '<\?=\s*\$h\((.+?)\)\s*\?>', '{{ $1 }}')
$raw = [regex]::Replace($raw, '<\?=\s*\(int\)\s*(.+?)\s*\?>', '{{ (int) $1 }}')
$raw = [regex]::Replace($raw, '<\?=\s*(.+?)\s*\?>', '{{ $1 }}')

# Keep data PHP blocks as @php for manual cleanup; drop layout/partial requires later
$raw = [regex]::Replace($raw, '(?s)<\?php\s+(.*?)\s*\?>', {
  param($m)
  $body = $m.Groups[1].Value.Trim()
  if ($body -eq '') { return '' }
  if ($body -match 'layout/(start|end)') { return '' }
  return "@php`n$body`n@endphp"
})

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
  $key = 'images/' + ($relative -replace '^/+', '' -replace '^images/', '')
  if ($pathMap.ContainsKey($key)) { return $pathMap[$key] }
  $key2 = 'images/' + ($relative -replace '^/+', '')
  if ($pathMap.ContainsKey($key2)) { return $pathMap[$key2] }
  return 'assets/media/' + ($relative -replace '^/+', '' -replace '^images/', '')
}

$raw = [regex]::Replace($raw, "bg-\[url\('/images/([^']+)'\)\]", {
  param($m)
  $p = Resolve-AssetPath $m.Groups[1].Value
  "bg-cover bg-top bg-no-repeat`" style=`"background-image: url('{{ asset('$p') }}')"
})

$raw = [regex]::Replace($raw, 'src="/images/([^"]+)"', {
  param($m)
  $p = Resolve-AssetPath $m.Groups[1].Value
  "src=`"{{ asset('$p') }}`""
})

$raw = [regex]::Replace($raw, "url\('/images/([^']+)'\)", {
  param($m)
  $p = Resolve-AssetPath $m.Groups[1].Value
  "url('{{ asset('$p') }}')"
})

# product images
$raw = [regex]::Replace($raw, 'src="/images/product/([^"]+)"', {
  param($m)
  "src=`"{{ asset('assets/product/$($m.Groups[1].Value)') }}`""
})

$customCss = ''
$scripts = ''
if ($raw -match '(?s)(<style>.*?</style>)') {
  $customCss = $Matches[1]
  $raw = $raw.Replace($Matches[1], '')
}
$scriptMatches = [regex]::Matches($raw, '(?s)<script(?![^>]*src=)[^>]*>.*?</script>')
if ($scriptMatches.Count -gt 0) {
  $scripts = ($scriptMatches | ForEach-Object { $_.Value }) -join "`n"
  foreach ($sm in $scriptMatches) { $raw = $raw.Replace($sm.Value, '') }
}

$out = @"
@extends('layouts.frontend')

@section('seo')
  <x-layouts.seo
    title="$SeoTitle"
    description="$SeoDescription"
    og-title="$SeoTitle"
    og-description="$SeoDescription"
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

$dir = Split-Path $Dest -Parent
if (-not (Test-Path $dir)) { New-Item -ItemType Directory -Path $dir | Out-Null }
$utf8 = New-Object System.Text.UTF8Encoding $false
[IO.File]::WriteAllText($Dest, $out, $utf8)
Write-Output "Wrote $Dest ($($out.Length) chars)"
