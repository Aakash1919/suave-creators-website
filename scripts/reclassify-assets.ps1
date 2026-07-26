$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
$assetsDir = Join-Path $root 'public\assets'
$mapPath = Join-Path $PSScriptRoot 'asset-path-map.json'
$renameMapPath = Join-Path $PSScriptRoot 'asset-rename-map.json'

if (-not (Test-Path $assetsDir)) {
    Write-Error "Missing $assetsDir"
}

$techDir = Join-Path $assetsDir 'icons\tech'
if (-not (Test-Path $techDir)) {
    New-Item -ItemType Directory -Path $techDir | Out-Null
}

function Test-IsTechStackLogo([string]$name) {
    $n = $name.ToLowerInvariant()

    # Service capability visuals (embedded product shots) stay in icons/, not tech/
    if ($n -match '-development-icon\.') { return $false }
    if ($n -match 'custom-ecommerce') { return $false }

    if ($n -match '^(laravel|wordpress|angular|vue|react|python|php|shopify|magento|nodejs|woocommerce)(-|_)') { return $true }
    if ($n -match '^(laravel|wordpress|angular|vue|react|python|php|shopify|magento|nodejs|woocommerce)\.(svg|png|webp)$') { return $true }
    if ($n -match '^(laravel|wordpress|angular|vue|react)-logo(-alt)?\.(svg|png|webp)$') { return $true }
    if ($n -match '^(php|python)-logo\.(svg|png|webp)$') { return $true }
    if ($n -match '^(shopify|react|php|nodejs|wordpress)-technology-icon\.(svg|png|webp)$') { return $true }
    if ($n -match '^(angular|codeigniter|html5|javascript|magento|nodedotjs|python|react|vuedotjs|wordpress)\.svg$') { return $true }

    return $false
}

function Test-IsRealClientLogo([string]$name) {
    $n = $name.ToLowerInvariant()
    if (Test-IsTechStackLogo $name) { return $false }
    if ($n -match '^(bioassay|verysoul|redsixity|dajj|ematrics)') { return $true }
    if ($n -match '^(enterprise-partner-logo|client-logo-)') { return $true }
    return $false
}

function Test-IsDedicatedIcon([string]$name) {
    $n = $name.ToLowerInvariant()
    if (Test-IsTechStackLogo $name) { return $true }
    if ($n -match 'icon') { return $true }
    if ($n -match '^(rocket|experience|funding|future)\.') { return $true }
    return $false
}

function Get-DedicatedCategory([string]$relativePath, [string]$name) {
    $n = $name.ToLowerInvariant()
    $rel = $relativePath.ToLowerInvariant() -replace '\\', '/'
    $folder = ($rel -split '/')[0]

    # Never reshuffle dedicated content trees (SEO names no longer match old prefixes)
    if ($folder -in @('product', 'portfolio', 'blog', 'background', 'brand')) {
        return $null
    }

    # Tech stack logos → icons/tech
    if (Test-IsTechStackLogo $name) {
        if ($rel -match '^icons/tech/') { return $null }
        return 'icons/tech'
    }

    # Team photos / portraits / consultation (keep in team; pull back from media/icons)
    if (
        $n -match '^(team-|consult|expert-|teams\.|team\.|professional-|open-office|metallic-s|bright-creative|teamwork-icon)' -or
        $n -match 'portrait' -or
        ($folder -eq 'team')
    ) {
        if ($folder -eq 'team') { return $null }
        # Only pull team-like files into team from media/icons root
        if ($folder -in @('media', 'icons') -and (
            $n -match '^(consult|professional-|open-office|metallic-s|bright-creative|team-|expert-|teamwork-icon)' -or
            ($n -match 'portrait' -and $n -notmatch 'testimonial')
        )) {
            return 'team'
        }
        if ($folder -eq 'team') { return $null }
    }

    # Brand chrome
    if ($n -match '^(logo|logo-white|logo-mark-shape|logo-shape|chat-widget-icon|chat|maintenance-mark-logo|maintenance-logo)\.') {
        if ($folder -eq 'brand') { return $null }
        return 'brand'
    }

    # Client / partner company logos
    if (Test-IsRealClientLogo $name) {
        if ($folder -eq 'clients') { return $null }
        return 'clients'
    }

    # Hero marketing motion (homepage) — not product page hero-*
    if ($n -match '^(hero-motion|hero-pattern|hero_|phone\.gif|mobile-app-phone)') {
        if ($folder -eq 'hero') { return $null }
        return 'hero'
    }

    # Icons: keep dedicated icons under icons/ (not tech unless tech logo)
    if (Test-IsDedicatedIcon $name) {
        if ($rel -match '^icons/tech/') { return $null }
        if ($folder -eq 'icons') { return $null }
        if ($folder -eq 'clients' -and $n -match 'icon') { return 'icons' }
        if ($folder -eq 'media') { return 'icons' }
        return 'icons'
    }

    # Non-icons wrongly under icons/ → media (never touch icons/tech)
    if ($rel.StartsWith('icons/') -and $rel -notmatch '^icons/tech/') {
        return 'media'
    }

    if ($rel.StartsWith('media/')) { return $null }
    if ($folder -eq 'clients') { return $null }
    if ($folder -eq 'hero') { return $null }
    if ($folder -eq 'team') { return $null }

    return 'media'
}

$moves = @()
Get-ChildItem -Path $assetsDir -File -Recurse | ForEach-Object {
    $rel = $_.FullName.Substring($assetsDir.Length + 1)
    $category = Get-DedicatedCategory $rel $_.Name
    if ($null -eq $category) { return }

    $destDir = Join-Path $assetsDir ($category -replace '/', '\')
    if (-not (Test-Path $destDir)) {
        New-Item -ItemType Directory -Path $destDir -Force | Out-Null
    }
    $dest = Join-Path $destDir $_.Name
    if ($dest -eq $_.FullName) { return }

    if (Test-Path $dest) {
        Remove-Item -LiteralPath $dest -Force
    }

    $oldKey = 'assets/' + ($rel -replace '\\', '/')
    $newKey = ("assets/$category/$($_.Name)") -replace '\\', '/'
    Move-Item -LiteralPath $_.FullName -Destination $dest
    $moves += [pscustomobject]@{ Old = $oldKey; New = $newKey }
    Write-Host ("MOVE {0} -> {1}" -f $oldKey, $newKey)
}

Write-Host ("Moved {0} file(s)." -f $moves.Count)

if ($moves.Count -eq 0) {
    Write-Host 'No reclassification needed.'
    exit 0
}

function Update-JsonPathMap([string]$path, $moves) {
    if (-not (Test-Path $path)) { return }
    $json = Get-Content -Raw -Path $path | ConvertFrom-Json
    $hash = [ordered]@{}
    $lookup = @{}
    foreach ($m in $moves) { $lookup[$m.Old] = $m.New }

    foreach ($prop in $json.PSObject.Properties) {
        $val = [string]$prop.Value
        $normalized = $val -replace '\\', '/'
        if ($lookup.ContainsKey($normalized)) {
            $val = $lookup[$normalized]
        } else {
            foreach ($m in $moves) {
                $oldRel = $m.Old -replace '^assets/', ''
                $newRel = $m.New -replace '^assets/', ''
                if ($normalized -eq $oldRel) { $val = $newRel; break }
                if ($normalized -eq $m.Old) { $val = $m.New; break }
            }
        }
        $hash[$prop.Name] = $val
    }

    foreach ($m in $moves) {
        $hash[$m.Old] = $m.New
        $hash['/' + $m.Old] = $m.New
    }

    ($hash | ConvertTo-Json -Depth 3) | Set-Content -Path $path -Encoding UTF8
    Write-Host "Updated $path"
}

Update-JsonPathMap $mapPath $moves
Update-JsonPathMap $renameMapPath $moves

$targets = @()
$targets += Get-ChildItem (Join-Path $root 'app') -Recurse -Include *.php -File -ErrorAction SilentlyContinue
$targets += Get-ChildItem (Join-Path $root 'resources\views') -Recurse -Include *.php,*.blade.php -File -ErrorAction SilentlyContinue
$targets += Get-ChildItem (Join-Path $root 'public\css') -Recurse -Include *.css -File -ErrorAction SilentlyContinue
$targets += Get-ChildItem (Join-Path $root 'scripts') -Recurse -Include *.ps1,*.json -File -ErrorAction SilentlyContinue

$pairs = $moves | Sort-Object { $_.Old.Length } -Descending
$changed = 0
foreach ($file in $targets) {
    if ($file.Name -eq 'reclassify-assets.ps1') { continue }
    $content = [IO.File]::ReadAllText($file.FullName)
    $original = $content
    foreach ($pair in $pairs) {
        $content = $content.Replace($pair.Old, $pair.New)
        $content = $content.Replace('/' + $pair.Old, '/' + $pair.New)
        $oldRel = $pair.Old -replace '^assets/', ''
        $newRel = $pair.New -replace '^assets/', ''
        $content = $content.Replace('"' + $oldRel + '"', '"' + $newRel + '"')
    }
    if ($content -ne $original) {
        [IO.File]::WriteAllText($file.FullName, $content)
        $changed++
        Write-Host ("Updated refs: " + $file.FullName.Substring($root.Length + 1))
    }
}

Write-Host ("Code files updated: {0}" -f $changed)
Write-Host 'Done.'
