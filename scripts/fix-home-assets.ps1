$ErrorActionPreference = 'Stop'
# Remap any leftover images/ paths in home.blade.php using asset-path-map.json
$root = Split-Path -Parent $PSScriptRoot
$p = Join-Path $root 'resources\views\frontend\home.blade.php'
$mapPath = Join-Path $PSScriptRoot 'asset-path-map.json'

if (-not (Test-Path $mapPath)) {
    Write-Error "Missing $mapPath — run organize-assets.ps1 first"
}

$c = [IO.File]::ReadAllText($p)
$map = Get-Content -Raw -Path $mapPath | ConvertFrom-Json
$pairs = @()
foreach ($prop in $map.PSObject.Properties) {
    if ($prop.Name.StartsWith('/')) { continue }
    $pairs += [pscustomobject]@{ Old = $prop.Name; New = [string]$prop.Value }
}
$pairs = $pairs | Sort-Object { $_.Old.Length } -Descending

foreach ($pair in $pairs) {
    $c = $c.Replace($pair.Old, $pair.New)
    $c = $c.Replace('/' + $pair.Old, $pair.New)
}

[IO.File]::WriteAllText($p, $c)
Write-Output 'fixed'
Write-Output ("remaining images/: " + ([regex]::Matches($c, "images/").Count))
