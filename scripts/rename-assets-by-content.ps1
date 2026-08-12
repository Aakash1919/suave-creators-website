$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
$assetsDir = Join-Path $root 'public\assets'
$mapOut = Join-Path $PSScriptRoot 'asset-rename-map.json'
$pathMapFile = Join-Path $PSScriptRoot 'asset-path-map.json'

function ConvertTo-Kebab([string]$value) {
    $s = $value.ToLowerInvariant()
    $s = $s -replace '[_\s]+', '-'
    $s = $s -replace '[^a-z0-9-]', '-'
    $s = $s -replace '-{2,}', '-'
    $s = $s.Trim('-')
    return $s
}

# Explicit content-based overrides (old relative under assets/ -> new filename only or full relative)
$explicit = [ordered]@{
    # Clients (from logos / HomeSupport labels)
    'clients/client-logo-1.png' = 'clients/bioassay-systems-logo.png'
    'clients/client-logo-4.png' = 'clients/verysoul-logo.png'
    'clients/client-logo-6.svg' = 'clients/redsixity-logo.svg'
    'clients/client-logo-7.png' = 'clients/dajj-logistics-logo.png'
    'clients/client-logo-8.png' = 'clients/ematrics-logo.png'
    'clients/client.svg' = 'icons/client-focus-icon.svg'

    # Brand (canonical names: logo.png / logo-white.png)
    'brand/chat.png' = 'brand/chat-widget-icon.png'
    'brand/chat.svg' = 'brand/chat-widget-icon.svg'
    'brand/maintenance-logo.png' = 'brand/maintenance-mark-logo.png'
    'brand/logo-shape.svg' = 'brand/logo-mark-shape.svg'

    # Team — content-based (reviewed / alt-aligned)
    'team/team-1.png' = 'media/metallic-s-logo-office-wall.png'
    'team/team-2.png' = 'team/professional-man-navy-blazer-portrait.png'
    'team/team-3.png' = 'media/professional-designer-portrait.png'
    'team/team-4.png' = 'media/professional-team-member-portrait.png'
    'team/team-5.png' = 'team/professional-woman-product-team-portrait.png'
    'team/team-6.png' = 'media/professional-team-lead-portrait.png'
    'team/team-7.png' = 'media/open-office-meeting-space.png'
    'team/team-8.png' = 'media/bright-creative-office-interior.png'
    'team/team-9.png' = 'team/team-working-modern-office.png'
    'team/team-10.png' = 'media/open-office-collaboration-space.png'
    'team/team.svg' = 'team/expert-team-icon.svg'
    'team/teams.svg' = 'icons/teamwork-icon.svg'
    'team/expert-1.png' = 'team/expert-portrait-1.png'
    'team/expert-2.png' = 'team/expert-portrait-2.png'
    'team/expert-3.png' = 'team/expert-portrait-3.png'
    'team/expert-4.png' = 'team/expert-portrait-4.png'
    'team/consult-1.png' = 'media/consultation-team-member-1.png'
    'team/consult-2.png' = 'media/consultation-team-member-2.png'
    'team/consult-3.png' = 'media/consultation-team-leader.png'
    'team/consult-4.png' = 'media/consultation-designer.png'
    'team/consult-5.png' = 'media/consultation-team-lead.png'
    'team/consult-6.png' = 'media/consultation-team-collaborating.png'

    # Home service icons
    'icons/dev-icon-1.svg' = 'icons/web-development-icon.svg'
    'icons/dev-icon-2.svg' = 'icons/enterprise-software-icon.svg'
    'icons/dev-icon-3.svg' = 'icons/ui-ux-design-icon.svg'
    'icons/dev-icon-4.svg' = 'icons/custom-crm-icon.svg'
    'icons/dev-icon-5.svg' = 'icons/ecommerce-development-icon.svg'
    'icons/dev-icon-6.svg' = 'icons/ai-solutions-icon.svg'
    'icons/market-icon-1.svg' = 'icons/seo-icon.svg'
    'icons/market-icon-2.svg' = 'icons/ppc-advertising-icon.svg'
    'icons/market-icon-3.svg' = 'icons/social-media-marketing-icon.svg'
    'icons/market-icon-4.svg' = 'icons/content-strategy-icon.svg'
    'icons/market-icon-5.svg' = 'icons/online-reputation-icon.svg'
    'icons/market-icon-6.svg' = 'icons/answer-engine-optimization-icon.svg'
    'icons/market-icon-7.svg' = 'icons/generative-engine-optimization-icon.svg'
    'icons/rocket.svg' = 'icons/brands-growth-rocket-icon.svg'
    'icons/rocket_icon.svg' = 'icons/announcement-rocket-icon.svg'
    'icons/experience.svg' = 'icons/years-experience-icon.svg'
    'icons/funding.svg' = 'icons/funding-secured-icon.svg'
    'icons/future.svg' = 'icons/future-ready-icon.svg'

    # Marketing media (home)
    'media/market-1.png' = 'media/seo-infographic-on-imac.png'
    'media/market-2.png' = 'media/ppc-campaign-planning.png'
    'media/market-3.png' = 'media/social-media-marketing-mobile.png'
    'media/market-4.png' = 'media/content-strategy-team-planning.png'
    'media/faq-gif.gif' = 'media/faq-team-collaboration.gif'

    # Portfolio
    'portfolio/portfolio-1.png' = 'media/modern-office-yellow-accent-lounge.png'
    'portfolio/portfolio-2.png' = 'media/contemporary-living-room-kitchen.png'
    'portfolio/portfolio-3.png' = 'media/warm-lounge-plants-artwork.png'
    'portfolio/portfolio-4.png' = 'media/office-glass-meeting-rooms.png'
    'portfolio/project-1.png' = 'media/timber-glass-creative-studio.png'
    'portfolio/project-2.png' = 'media/bright-contemporary-residence.png'
    'portfolio/project-3.png' = 'media/warm-modern-lounge-interior.png'
    'portfolio/project-analysis.png' = 'portfolio/project-analysis-dashboard.png'
    'portfolio/portfolioimg1.webp' = 'portfolio/swastik-culture-hub-website.webp'
    'portfolio/portfolioimg2.webp' = 'portfolio/mavan-growth-agency-website.webp'
    'portfolio/portfolioimg3.webp' = 'portfolio/sales-automation-project-dashboard.webp'
    'portfolio/portfolioimg4.webp' = 'portfolio/hubops-software-company-website.webp'
    'portfolio/portfolioimg5.webp' = 'portfolio/suave-outreach-crm-laptop.webp'
    'portfolio/portfolioimg6.webp' = 'portfolio/ematrics-ai-sales-website.webp'

    # Blog
    'blog/blog-1.png' = 'blog/digital-strategy-collaboration.png'
    'blog/blog-2.png' = 'blog/product-experience-mapping.png'
    'blog/blog-3.png' = 'blog/software-development-laptop-code.png'
    'blog/insight-digital-strategy.jpg' = 'blog/insight-digital-strategy.jpg'
    'blog/insight-future-work.jpg' = 'blog/insight-future-of-work.jpg'
    'blog/insight-product-growth.jpg' = 'blog/insight-product-growth.jpg'

    # Hero
    'hero/hero_gif1.gif' = 'hero/hero-motion-panel-1.gif'
    'hero/hero_gif2.gif' = 'hero/hero-motion-panel-2.gif'
    'hero/hero_gif3.gif' = 'hero/hero-motion-panel-3.gif'
    'hero/hero_Pattern(left).svg' = 'hero/hero-pattern-left.svg'
    'hero/phone.gif' = 'hero/mobile-app-phone-demo.mp4'

    # Backgrounds
    'background/background_about.png' = 'background/about-section-bg.png'
    'background/background_core_values.png' = 'background/core-values-section-bg.png'
    'background/about-banner-bg.png' = 'background/about-banner-bg.png'
    'background/blog-bg.png' = 'background/blog-section-bg.png'
    'background/consultation-bg.png' = 'background/consultation-section-bg.png'
    'background/core-bg.png' = 'background/core-section-bg.png'
    'background/cover_banner.png' = 'background/home-hero-cover-bg.png'
    'background/dev-bg.png' = 'background/web-services-section-bg.png'
    'background/footer-bg.png' = 'background/footer-bg.png'
    'background/industry-bg.png' = 'background/industries-section-bg.png'
    'background/market-bg.png' = 'background/digital-marketing-section-bg.png'
    'background/portfolio-bg.png' = 'background/portfolio-section-bg.png'
    'background/smart-bg.png' = 'background/offerings-section-bg.png'
    'background/testimonial-bg.png' = 'background/testimonials-section-bg.png'
    'background/testimonial-card-bg.png' = 'background/testimonial-card-bg.png'
    'background/web-bg.png' = 'background/technology-section-bg.png'
    'background/service-banner-bg.webp' = 'background/service-banner-bg.webp'
    'background/edu-future-bg.webp' = 'background/education-future-bg.webp'
    'background/enter-service-bg.webp' = 'background/enterprise-service-bg.webp'
    'background/enter-service-bg-1.webp' = 'background/enterprise-service-alt-bg.webp'
    'background/finance-future-bg.webp' = 'background/finance-future-bg.webp'
    'background/health-bg.webp' = 'background/healthcare-section-bg.webp'
    'background/industry-future-bg.webp' = 'background/industry-future-bg.webp'
    'background/it-future-bg.webp' = 'background/it-future-bg.webp'
    'background/retail-future-bg.webp' = 'background/retail-future-bg.webp'
    'background/supply-future-bg.webp' = 'background/supply-chain-future-bg.webp'
    'background/webhealth-bg.webp' = 'background/web-healthcare-bg.webp'
    'background/webservice-bg.webp' = 'background/web-service-bg.webp'
    'background/webservice-bg-1.webp' = 'background/web-service-alt-1-bg.webp'
    'background/webservice-bg-2.webp' = 'background/web-service-alt-2-bg.webp'
    'background/work-with-us-bg.webp' = 'background/work-with-us-bg.webp'
    'background/work-with-us-bg-1.webp' = 'background/work-with-us-alt-1-bg.webp'
    'background/work-with-us-bg-3.webp' = 'background/work-with-us-alt-3-bg.webp'
    'background/work-with-us-bg-4.webp' = 'background/work-with-us-alt-4-bg.webp'
}

function Get-AutoSeoRelative([string]$rel) {
    $rel = $rel -replace '\\', '/'
    if ($explicit.Contains($rel)) {
        $target = ([string]$explicit[$rel]) -replace '\\', '/'
        if ($target -eq $rel) { return $null }
        $oldDir = Split-Path $rel -Parent
        $newDir = Split-Path $target -Parent
        if (($newDir -replace '\\', '/') -ne ($oldDir -replace '\\', '/')) {
            $target = (($oldDir -replace '\\', '/') + '/' + (Split-Path $target -Leaf)).TrimStart('/')
        }
        if ($target -eq $rel) { return $null }
        return $target
    }

    $dir = Split-Path $rel -Parent
    $file = Split-Path $rel -Leaf
    $ext = [IO.Path]::GetExtension($file)
    $base = [IO.Path]::GetFileNameWithoutExtension($file)

    # Already SEO-ish tech names
    if ($rel -match '^icons/tech/') { return $null }
    if ($base -in @('logo', 'logo-white', 'react', 'angular', 'python', 'javascript', 'html5', 'magento', 'wordpress')) { return $null }

    $name = $base

    # Normalize common patterns
    $name = $name -replace '^background_', ''
    $name = $name -replace '_', '-'
    $name = $name -replace '\(', '-'
    $name = $name -replace '\)', ''
    $name = $name -replace 'e-com-', 'ecommerce-'
    $name = $name -replace 'e-commerece', 'ecommerce'
    $name = $name -replace '^crm-dev-img-', 'crm-development-visual-'
    $name = $name -replace '^crm-development-banner', 'crm-development-banner'
    $name = $name -replace '^retail-image-', 'retail-solutions-visual-'
    $name = $name -replace '^personal-edu-icon-', 'education-personalization-icon-'
    $name = $name -replace '^personal-finance-icon-', 'finance-personalization-icon-'
    $name = $name -replace '^personal-health-icon-', 'healthcare-personalization-icon-'
    $name = $name -replace '^health-icon', 'healthcare-icon'
    $name = $name -replace '^health-brand-icon-', 'healthcare-brand-icon-'
    $name = $name -replace '^edu-icon-', 'education-icon-'
    $name = $name -replace '^edu-brand-icon-', 'education-brand-icon-'
    $name = $name -replace '^fin-special-icon-', 'finance-specialized-icon-'
    $name = $name -replace '^finance-icon', 'finance-icon'
    $name = $name -replace '^finance-brand-icon-', 'finance-brand-icon-'
    $name = $name -replace '^it-icon-', 'it-solutions-icon-'
    $name = $name -replace '^it-brand-icon-', 'it-brand-icon-'
    $name = $name -replace '^it-special-icon-', 'it-specialized-icon-'
    $name = $name -replace '^retail-icon-', 'retail-icon-'
    $name = $name -replace '^retail-brand-icon-', 'retail-brand-icon-'
    $name = $name -replace '^logistic-brand-', 'logistics-brand-icon-'
    $name = $name -replace '^logistic-banner', 'logistics-banner'
    $name = $name -replace '^supply-icon-', 'supply-chain-icon-'
    $name = $name -replace '^sup-icon', 'support-icon'
    # com-service-icon-* mapped explicitly in asset-rename-map.json (woocommerce/shopify/magento/custom)
    $name = $name -replace '^crm-service-icon-', 'crm-service-icon-'
    $name = $name -replace '^crm-icon-', 'crm-icon-'
    $name = $name -replace '^e-com-icon-', 'ecommerce-icon-'
    $name = $name -replace '^soft-icon-', 'software-icon-'
    $name = $name -replace '^special-icon-', 'specialized-service-icon-'
    $name = $name -replace '^service-icon-', 'service-icon-'
    # service-logo-* mapped explicitly in asset-rename-map.json (vue/angular/python/react/laravel/php)
    $name = $name -replace '^enter-logo-', 'enterprise-partner-logo-'
    $name = $name -replace '^enter-dev-tech-', 'enterprise-technology-icon-'
    # tech-dev-* mapped explicitly in asset-rename-map.json (laravel/wordpress/react/angular/php/nodejs)
    # tech-icon-* mapped explicitly in asset-rename-map.json (shopify/react/php/nodejs/wordpress)
    $name = $name -replace '^web-service-', 'web-service-icon-'
    $name = $name -replace '^agile-icon-', 'agile-icon-'
    $name = $name -replace '^core-icon-', 'core-value-icon-'
    $name = $name -replace '^industry-icon-', 'industry-icon-'
    # black-logo-* mapped explicitly in asset-rename-map.json (laravel/wordpress/angular/vue/react)
    $name = $name -replace '^ai-service-', 'ai-service-visual-'
    $name = $name -replace '^about-shore-', 'about-shore-visual-'
    $name = $name -replace '^about-banner-image', 'about-banner-visual'
    $name = $name -replace '^cos-business-', 'business-visual-'
    $name = $name -replace '^business-', 'business-visual-'
    $name = $name -replace '^industry-left', 'industry-left-visual'
    $name = $name -replace '^industry-right', 'industry-right-visual'
    $name = $name -replace '^industry-healthcare', 'industry-healthcare-visual'
    $name = $name -replace '^offering-digital-marketing', 'digital-marketing-offering-visual'
    $name = $name -replace '^endtoenddevelopmentexpertise', 'end-to-end-development-expertise'
    $name = $name -replace '^global-and-scalable-security', 'global-scalable-security'
    $name = $name -replace '^SEO-Performance-Optimization', 'seo-performance-optimization'
    $name = $name -replace '^customer-support-ticketing', 'customer-support-ticketing'
    $name = $name -replace '^evaluating-industry-software', 'evaluating-industry-software'
    $name = $name -replace '^industry-design-development', 'industry-design-development'
    $name = $name -replace '^industry-discovery-strategy', 'industry-discovery-strategy'
    $name = $name -replace '^industry-goals', 'industry-goals'
    $name = $name -replace '^industry-launch-growth', 'industry-launch-growth'
    $name = $name -replace '^industry-multi-channel-communication', 'industry-multi-channel-communication'
    $name = $name -replace '^industry-specific-solutions', 'industry-specific-solutions'
    $name = $name -replace '^industry-user-centric-design', 'industry-user-centric-design'
    $name = $name -replace '^service-move-', 'service-process-step-'
    $name = $name -replace '^finance-banner', 'finance-banner'
    $name = $name -replace '^health-banner', 'healthcare-banner'
    $name = $name -replace '^it-banner', 'it-solutions-banner'
    $name = $name -replace '^retail-banner', 'retail-banner'
    $name = $name -replace '^education-banner', 'education-banner'
    $name = $name -replace '^enterprise-banner', 'enterprise-banner'
    $name = $name -replace '^ecommerce-banner', 'ecommerce-banner'
    $name = $name -replace '^build-strategy', 'build-strategy-visual'
    $name = $name -replace '^build$', 'build-visual'
    $name = $name -replace '^collab-back', 'collaboration-back-visual'
    $name = $name -replace '^collab-front', 'collaboration-front-visual'
    $name = $name -replace '^circular-text', 'circular-text-badge'
    $name = $name -replace '^circularicon', 'circular-icon'
    $name = $name -replace '^development-vector', 'development-vector-visual'
    $name = $name -replace '^launch-live', 'launch-live-visual'
    $name = $name -replace '^right-transform', 'right-transform-visual'
    $name = $name -replace '^testimonial-1', 'testimonial-portrait-1'
    $name = $name -replace '^topimage', 'top-banner-visual'
    $name = $name -replace 'nodedotjs', 'nodejs'
    $name = $name -replace 'vuedotjs', 'vuejs'

    # Product folder hashes -> keep short descriptive if hash-like
    if ($dir -eq 'product' -and $name -match '^[a-f0-9]{20,}$') {
        $name = "product-animation-$($name.Substring(0,8))"
    }

    $name = ConvertTo-Kebab $name

    # Ensure icon suffix for icon folder files that lost it
    if ($dir -eq 'icons' -or $dir -eq 'icons/tech') {
        if ($name -notmatch 'icon' -and $name -notmatch 'logo' -and $ext -eq '.svg') {
            if ($name -notmatch '^(react|angular|python|javascript|html5|magento|wordpress|nodejs|vuejs|codeigniter)$') {
                $name = "$name-icon"
            }
        }
    }

    # Backgrounds should end with -bg when they are backgrounds
    if ($dir -eq 'background' -and $name -notmatch '-bg$' -and $name -notmatch 'banner') {
        if ($name -match 'cover|hero') { }
        elseif ($name -notmatch '-bg$') { $name = "$name-bg" }
    }

    $newRel = if ([string]::IsNullOrEmpty($dir) -or $dir -eq '.') { "$name$ext" } else { "$dir/$name$ext" }
    $newRel = $newRel.ToLowerInvariant()
    # preserve known casing for nothing — all lower

    if ($newRel -eq $rel.ToLowerInvariant() -and $rel -ceq $newRel) { return $null }
    if ($newRel -eq ($rel -replace '\\', '/')) { return $null }
    if ($newRel -eq $rel) { return $null }

    # If only case change on windows-insensitive FS, skip unless different chars
    if ($newRel.ToLowerInvariant() -eq $rel.ToLowerInvariant() -and $newRel -ne $rel) {
        return $newRel
    }
    if ($newRel -eq $rel) { return $null }
    return $newRel
}

# Build map for all files
$files = Get-ChildItem -Path $assetsDir -Recurse -File
$renameMap = [ordered]@{}
$usedTargets = @{}

foreach ($file in $files) {
    $rel = $file.FullName.Substring($assetsDir.Length + 1) -replace '\\', '/'
    $newRel = Get-AutoSeoRelative $rel
    if ($null -eq $newRel) { continue }

    # Collision handling
    $candidate = $newRel
    $i = 2
    while ($true) {
        if ($candidate -eq $rel) { break }
        $takenInMap = $usedTargets.ContainsKey($candidate.ToLowerInvariant())
        $targetFull = Join-Path $assetsDir ($candidate -replace '/', [IO.Path]::DirectorySeparatorChar)
        $existsOnDisk = Test-Path -LiteralPath $targetFull
        $isSelf = $existsOnDisk -and ((Resolve-Path -LiteralPath $targetFull).Path -eq (Resolve-Path -LiteralPath $file.FullName).Path)
        if (-not $takenInMap -and (-not $existsOnDisk -or $isSelf)) { break }

        $dir = Split-Path $newRel -Parent
        $ext = [IO.Path]::GetExtension($newRel)
        $base = [IO.Path]::GetFileNameWithoutExtension($newRel)
        $base = $base -replace '-\d+$', ''
        $candidate = if ($dir) { "$dir/$base-$i$ext" } else { "$base-$i$ext" }
        $i++
        if ($i -gt 50) { throw "Too many collisions for $rel" }
    }

    $usedTargets[$candidate.ToLowerInvariant()] = $rel
    if ($candidate -ne $rel) {
        $renameMap[$rel] = $candidate
    }
}

($renameMap | ConvertTo-Json -Depth 3) | Set-Content -Path $mapOut -Encoding UTF8
Write-Host ("Wrote {0} renames to {1}" -f $renameMap.Count, $mapOut)

# Two-phase rename to avoid collisions
$tempPrefix = '__renaming__'
$phase1 = @()
foreach ($entry in $renameMap.GetEnumerator()) {
    $src = Join-Path $assetsDir ($entry.Name -replace '/', '\')
    $tmpName = $tempPrefix + [Guid]::NewGuid().ToString('N') + [IO.Path]::GetExtension($entry.Name)
    $tmp = Join-Path (Split-Path $src -Parent) $tmpName
    Move-Item -LiteralPath $src -Destination $tmp
    $phase1 += [pscustomobject]@{ Temp = $tmp; DestRel = $entry.Value; OldRel = $entry.Name }
}

foreach ($item in $phase1) {
    $dest = Join-Path $assetsDir ($item.DestRel -replace '/', '\')
    $destDir = Split-Path $dest -Parent
    if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir | Out-Null }
    if (Test-Path $dest) { Remove-Item -LiteralPath $dest -Force }
    Move-Item -LiteralPath $item.Temp -Destination $dest
    Write-Host ("RENAMED {0} -> {1}" -f $item.OldRel, $item.DestRel)
}

# Update asset-path-map.json values
if (Test-Path $pathMapFile) {
    $json = Get-Content -Raw $pathMapFile | ConvertFrom-Json
    $hash = [ordered]@{}
    foreach ($prop in $json.PSObject.Properties) {
        $val = [string]$prop.Value
        $assetsRel = $val -replace '^/+', ''
        if ($assetsRel.StartsWith('assets/')) {
            $inner = $assetsRel.Substring('assets/'.Length)
            if ($renameMap.Contains($inner)) {
                $val = 'assets/' + $renameMap[$inner]
            }
        }
        $hash[$prop.Name] = $val
    }
    foreach ($entry in $renameMap.GetEnumerator()) {
        $hash['assets/' + $entry.Name] = 'assets/' + $entry.Value
        $hash['/assets/' + $entry.Name] = 'assets/' + $entry.Value
        $hash['images/' + (Split-Path $entry.Name -Leaf)] = 'assets/' + $entry.Value
    }
    ($hash | ConvertTo-Json -Depth 3) | Set-Content $pathMapFile -Encoding UTF8
    Write-Host "Updated asset-path-map.json"
}

# Rewrite code references (longest first)
$pairs = @()
foreach ($entry in $renameMap.GetEnumerator()) {
    $pairs += [pscustomobject]@{
        Old = 'assets/' + $entry.Name
        New = 'assets/' + $entry.Value
    }
}
$pairs = $pairs | Sort-Object { $_.Old.Length } -Descending

$targets = @()
$targets += Get-ChildItem (Join-Path $root 'app') -Recurse -Include *.php -File -ErrorAction SilentlyContinue
$targets += Get-ChildItem (Join-Path $root 'resources\views') -Recurse -Include *.php,*.blade.php -File -ErrorAction SilentlyContinue
$targets += Get-ChildItem (Join-Path $root 'public\css') -Recurse -Include *.css -File -ErrorAction SilentlyContinue
$targets += Get-ChildItem (Join-Path $root 'scripts') -Recurse -Include *.ps1 -File -ErrorAction SilentlyContinue

$changedFiles = 0
foreach ($file in $targets) {
    if ($file.Name -eq 'rename-assets-by-content.ps1') { continue }
    $content = [IO.File]::ReadAllText($file.FullName)
    $original = $content
    foreach ($pair in $pairs) {
        $content = $content.Replace($pair.Old, $pair.New)
        $content = $content.Replace('/' + $pair.Old, '/' + $pair.New)
    }
    if ($content -ne $original) {
        [IO.File]::WriteAllText($file.FullName, $content)
        $changedFiles++
        Write-Host ("Updated: " + $file.FullName.Substring($root.Length + 1))
    }
}

Write-Host ("Code files updated: {0}" -f $changedFiles)
Write-Host 'Done.'
