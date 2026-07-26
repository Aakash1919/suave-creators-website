$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
$mapPath = Join-Path $PSScriptRoot 'asset-path-map.json'

if (-not (Test-Path $mapPath)) {
    Write-Error "Missing map: $mapPath (run organize-assets.ps1 first)"
}

$map = Get-Content -Raw -Path $mapPath | ConvertFrom-Json
# Convert PSCustomObject to hashtable sorted by key length (longest first)
$pairs = @()
foreach ($prop in $map.PSObject.Properties) {
    if ($prop.Name.StartsWith('/')) { continue } # avoid double-replace; handle via optional slash
    $pairs += [pscustomobject]@{ Old = $prop.Name; New = [string]$prop.Value }
}
$pairs = $pairs | Sort-Object { $_.Old.Length } -Descending

$targets = @()
$targets += Get-ChildItem -Path (Join-Path $root 'app') -Recurse -Include *.php -File
$targets += Get-ChildItem -Path (Join-Path $root 'resources\views') -Recurse -Include *.php,*.blade.php -File
$targets += Get-ChildItem -Path (Join-Path $root 'scripts') -Recurse -Include *.ps1 -File
$targets += Get-ChildItem -Path (Join-Path $root 'public\css') -Recurse -Include *.css -File

$changedFiles = 0
$totalReplacements = 0

foreach ($file in $targets) {
    if ($file.Name -eq 'organize-assets.ps1' -or $file.Name -eq 'rewrite-asset-paths.ps1' -or $file.Name -eq 'asset-path-map.json') {
        continue
    }

    $content = [IO.File]::ReadAllText($file.FullName)
    $original = $content

    foreach ($pair in $pairs) {
        $old = $pair.Old
        $new = $pair.New
        if ($content.Contains($old)) {
            $count = ([regex]::Matches($content, [regex]::Escape($old))).Count
            $content = $content.Replace($old, $new)
            $totalReplacements += $count
        }
        $oldSlash = '/' + $old
        if ($content.Contains($oldSlash)) {
            $count = ([regex]::Matches($content, [regex]::Escape($oldSlash))).Count
            $content = $content.Replace($oldSlash, $new)
            $totalReplacements += $count
        }
    }

    if ($content -ne $original) {
        [IO.File]::WriteAllText($file.FullName, $content)
        $changedFiles++
        Write-Host ("Updated: " + $file.FullName.Substring($root.Length + 1))
    }
}

Write-Host "Changed files: $changedFiles"
Write-Host "Total replacements: $totalReplacements"
