$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
$imagesDir = Join-Path $root 'public\images'
$assetsDir = Join-Path $root 'public\assets'
$mapPath = Join-Path $PSScriptRoot 'asset-path-map.json'

if (-not (Test-Path $imagesDir)) {
    Write-Error "Missing source folder: $imagesDir"
}

$categories = @(
    'brand',
    'team',
    'clients',
    'background',
    'hero',
    'blog',
    'portfolio',
    'icons',
    'media'
)

foreach ($category in $categories) {
    $dir = Join-Path $assetsDir $category
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir | Out-Null
    }
}

function Get-AssetCategory([string]$name) {
    $n = $name.ToLowerInvariant()

    if (
        $n -match '^(logo|logo-white|logo-shape|white_logo|gradient-logo|chat|maintenance-logo)\.(svg|png|webp)$' -or
        $n -match '(^|[-_])logo\.(svg|png|webp)$'
    ) {
        return 'brand'
    }

    if ($n -match '^(team-|consult-|expert-|teams\.svg|team\.svg)') {
        return 'team'
    }

    # Real client / partner company logos only (tech stack marks → icons/tech below)
    if ($n -match '^(client-logo-|client\.svg|enter-logo-|enterprise-partner-logo-|bioassay|verysoul|redsixity|dajj|ematrics)') {
        return 'clients'
    }

    if (
        $n -match '^(laravel|wordpress|angular|vue|react|python|php|shopify|magento|nodejs|woocommerce)(-|_)' -or
        $n -match '^(laravel|wordpress|angular|vue|react|python|php|nodejs)-logo' -or
        $n -match '^(shopify|react|php|nodejs|wordpress)-technology-icon' -or
        $n -match '^(black-logo-|partner-black-logo-|service-logo-|service-mark-logo-)'
    ) {
        return 'icons\tech'
    }

    if (
        $n -match '(^|[-_])bg(\.|[-_])' -or
        $n -match '-bg\.' -or
        $n -match '_bg\.' -or
        $n -match '^background_' -or
        $n -match '^(cover_banner|webservice-bg|work-with-us-bg|enter-service-bg|about-banner-bg|service-banner-bg)' -or
        $n -eq 'core-bg.png' -or
        $n -eq 'smart-bg.png' -or
        $n -eq 'web-bg.png' -or
        $n -eq 'dev-bg.png' -or
        $n -eq 'market-bg.png' -or
        $n -eq 'portfolio-bg.png' -or
        $n -eq 'industry-bg.png' -or
        $n -eq 'footer-bg.png' -or
        $n -eq 'blog-bg.png' -or
        $n -eq 'testimonial-bg.png' -or
        $n -eq 'testimonial-card-bg.png' -or
        $n -eq 'consultation-bg.png'
    ) {
        return 'background'
    }

    if ($n -match '^(hero_|phone\.gif)') {
        return 'hero'
    }

    if ($n -match '^(blog-|insight-)') {
        return 'blog'
    }

    if ($n -match '^(portfolio|project-|portfolioimg)') {
        return 'portfolio'
    }

    # Icons only: filename contains "icon", small UI marks, tech/service logo marks.
    # Photos, banners, illustrations fall through to media.
    if (
        $n -match 'icon' -or
        $n -match '^(rocket|rocket_icon|experience|funding|future)\.' -or
        $n -match '^(tech-dev-|enter-dev-tech-|web-service-|service-move-arrow|technology-development-icon-|laravel-development-icon|wordpress-development-icon|react-development-icon|angular-development-icon|php-development-icon|nodejs-development-icon|enterprise-technology-icon-|web-service-icon-|tech-icon-|technology-icon-|shopify-technology-icon|react-technology-icon|php-technology-icon|nodejs-technology-icon|wordpress-technology-icon)' -or
        $n -match '^(agile-|crm-service-|com-service-|soft-|special-|sup-icon|logistic-brand-|logistics-brand-icon-|commerce-service-icon-|woocommerce-development-icon|shopify-development-icon|magento-development-icon|custom-ecommerce-development-icon|support-icon)'
    ) {
        return 'icons'
    }

    # Fallback: anything without a dedicated category
    return 'media'
}

$files = Get-ChildItem -Path $imagesDir -File
$moved = @{}
$counts = @{}
foreach ($category in $categories) { $counts[$category] = 0 }
$counts['product'] = 0

foreach ($file in $files) {
    $category = Get-AssetCategory $file.Name
    $destDir = Join-Path $assetsDir $category
    $dest = Join-Path $destDir $file.Name

    if (Test-Path $dest) {
        Remove-Item -LiteralPath $dest -Force
    }

    Move-Item -LiteralPath $file.FullName -Destination $dest
    $oldKey = 'images/' + $file.Name
    $newKey = 'assets/' + $category + '/' + $file.Name
    $moved[$oldKey] = $newKey
    $counts[$category]++
}

# Known nested folders from design imports
$nestedMoves = @{
    'blogs-hero' = 'blog\blogs-hero'
    'logo'       = 'brand\logo'
    'product'    = 'product'
    'tech'       = 'icons\tech'
}

foreach ($entry in $nestedMoves.GetEnumerator()) {
    $src = Join-Path $imagesDir $entry.Name
    if (-not (Test-Path $src)) { continue }
    $dest = Join-Path $assetsDir $entry.Value
    $destParent = Split-Path -Parent $dest
    if (-not (Test-Path $destParent)) {
        New-Item -ItemType Directory -Path $destParent -Force | Out-Null
    }
    if (Test-Path $dest) {
        Get-ChildItem -LiteralPath $src -Force | ForEach-Object {
            $target = Join-Path $dest $_.Name
            if (Test-Path $target) { Remove-Item -LiteralPath $target -Recurse -Force }
            Move-Item -LiteralPath $_.FullName -Destination $dest
        }
        Remove-Item -LiteralPath $src -Recurse -Force -ErrorAction SilentlyContinue
    } else {
        Move-Item -LiteralPath $src -Destination $dest
    }
    Write-Host ("Moved nested folder images/{0} -> assets/{1}" -f $entry.Name, ($entry.Value -replace '\\', '/'))
}

# Also map leading-slash variants
$mapObject = [ordered]@{}
foreach ($entry in ($moved.GetEnumerator() | Sort-Object Name)) {
    $mapObject[$entry.Name] = $entry.Value
    $mapObject['/' + $entry.Name] = $entry.Value
}

$mapObject | ConvertTo-Json -Depth 3 | Set-Content -Path $mapPath -Encoding UTF8

Write-Host "Moved $($moved.Count) files from public/images to public/assets"
foreach ($category in $categories) {
    Write-Host ("  {0,-12} {1}" -f $category, $counts[$category])
}

$remainingFiles = @(Get-ChildItem -Path $imagesDir -File -ErrorAction SilentlyContinue)
$remainingDirs = @(Get-ChildItem -Path $imagesDir -Directory -ErrorAction SilentlyContinue)
if ($remainingFiles.Count -gt 0 -or $remainingDirs.Count -gt 0) {
    Write-Warning ("Unmoved items remain in public/images: files={0} dirs={1}" -f $remainingFiles.Count, $remainingDirs.Count)
    $remainingFiles | ForEach-Object { Write-Warning $_.Name }
    $remainingDirs | ForEach-Object { Write-Warning ("DIR " + $_.Name) }
    exit 1
}

# public/images is not allowed after organization
Remove-Item -LiteralPath $imagesDir -Recurse -Force -ErrorAction SilentlyContinue
if (Test-Path $imagesDir) {
    Write-Error 'Could not remove public/images — delete it manually. All media must live under public/assets/.'
}

Write-Host "Map written to $mapPath"
Write-Host 'Removed public/images (all media is under public/assets/).'
Write-Host 'Done.'
