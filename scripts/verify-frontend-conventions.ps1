$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
$failed = New-Object System.Collections.Generic.List[string]
$cleaned = New-Object System.Collections.Generic.List[string]

Write-Host 'The changes are being verified and unwanted file functions are being removed'

function Add-Fail([string]$message) {
    $failed.Add($message) | Out-Null
    Write-Host "FAIL: $message" -ForegroundColor Red
}

function Add-Clean([string]$message) {
    $cleaned.Add($message) | Out-Null
    Write-Host "CLEAN: $message" -ForegroundColor Yellow
}

# 1) public/images must not exist — everything lives under public/assets/
$imagesDir = Join-Path $root 'public\images'
if (Test-Path $imagesDir) {
    $loose = @(Get-ChildItem -Path $imagesDir -File -Recurse -ErrorAction SilentlyContinue)
    if ($loose.Count -gt 0) {
        Add-Fail ("public/images still contains {0} file(s); move into public/assets/{{category}}/ then delete public/images" -f $loose.Count)
    } else {
        Remove-Item -LiteralPath $imagesDir -Recurse -Force -ErrorAction SilentlyContinue
        if (-not (Test-Path $imagesDir)) {
            Add-Clean 'Removed empty public/images directory (not allowed)'
        }
    }
}

# Remove unused legacy brand duplicates when canonical logos exist
$brandDir = Join-Path $root 'public\assets\brand'
$legacyBrand = @{
    'white_logo.svg'    = 'logo-white.webp'
    'gradient-logo.svg' = 'logo.png'
}
foreach ($entry in $legacyBrand.GetEnumerator()) {
    $legacyPath = Join-Path $brandDir $entry.Name
    $canonicalPath = Join-Path $brandDir $entry.Value
    if ((Test-Path $legacyPath) -and (Test-Path $canonicalPath)) {
        Remove-Item -LiteralPath $legacyPath -Force
        Add-Clean ("Removed duplicate brand file assets/brand/{0} (use {1})" -f $entry.Name, $entry.Value)
    }
}

# 2) Scan app/views/css for forbidden path conventions
$codeFiles = @()
$codeFiles += Get-ChildItem (Join-Path $root 'app') -Recurse -Include *.php -File -ErrorAction SilentlyContinue
$codeFiles += Get-ChildItem (Join-Path $root 'resources\views') -Recurse -Include *.php,*.blade.php -File -ErrorAction SilentlyContinue
$codeFiles += Get-ChildItem (Join-Path $root 'public\css') -Recurse -Include *.css -File -ErrorAction SilentlyContinue

foreach ($file in $codeFiles) {
    $text = [IO.File]::ReadAllText($file.FullName)
    $rel = ($file.FullName.Substring($root.Length + 1) -replace '\\', '/')

    # Ignore comment-only mention of legacy images/ in the normalizer trait
    if ($rel -eq 'app/Support/Frontend/Concerns/NormalizesAssetPaths.php') {
        if ($text -match "['`"]images/") {
            Add-Fail "$rel still contains images/ path string"
        }
    } elseif ($text -match "['`"]/?images/" -or $text -match '(?<![a-zA-Z])/images/') {
        Add-Fail "$rel still contains images/ path reference"
    }

    if ($text -match 'white_logo\.svg' -or $text -match 'gradient-logo\.svg') {
        Add-Fail "$rel references legacy logo filename (use assets/brand/logo-white.webp or logo.png)"
    }
}

# 3) Marketing layout: Vite Tailwind + style.css; no star-pearl wired directly
$layout = Join-Path $root 'resources\views\layouts\frontend.blade.php'
if (Test-Path $layout) {
    $layoutText = [IO.File]::ReadAllText($layout)
    if ($layoutText -notmatch '@vite') {
        Add-Fail 'layouts/frontend.blade.php missing @vite (use Vite Tailwind, not Play CDN)'
    }
    if ($layoutText -match 'cdn\.tailwindcss\.com') {
        Add-Fail 'layouts/frontend.blade.php must not use Tailwind Play CDN'
    }
    if ($layoutText -match 'the-suave-star-pearl') {
        Add-Fail 'layouts/frontend.blade.php references the-suave-star-pearl'
    }
    if ($layoutText -notmatch "asset\('css/style\.css'\)") {
        Add-Fail "layouts/frontend.blade.php missing asset('css/style.css')"
    }
}

# 4) Section component naming drift (Frontend classes without Section postfix)
# Shared chrome helpers are allowed without Section (see suave-frontend skill).
$frontendDir = Join-Path $root 'app\View\Components\Frontend'
$nonSectionAllowlist = @('Bento', 'CtaArrow', 'CtaButton')
if (Test-Path $frontendDir) {
    Get-ChildItem $frontendDir -Filter *.php -File | ForEach-Object {
        if ($_.BaseName -notmatch 'Section$' -and $nonSectionAllowlist -notcontains $_.BaseName) {
            Add-Fail ("Frontend component {0} must end with Section" -f $_.Name)
        }
    }
}

# 5) Unwanted duplicate skill folders should not exist
$unwantedSkills = @(
    'frontend-css-organization',
    'frontend-section-components'
)
foreach ($skill in $unwantedSkills) {
    $skillPath = Join-Path $root ".cursor\skills\$skill"
    if (Test-Path $skillPath) {
        Remove-Item -LiteralPath $skillPath -Recurse -Force
        Add-Clean "Removed unwanted skill .cursor/skills/$skill"
    }
}

# 6) Required skill present
$requiredSkill = Join-Path $root '.cursor\skills\suave-frontend\SKILL.md'
if (-not (Test-Path $requiredSkill)) {
    Add-Fail 'Missing .cursor/skills/suave-frontend/SKILL.md'
}

# 7) icons/ must not hold banners/photos (those belong in media/ or another dedicated folder)
$iconsDir = Join-Path $root 'public\assets\icons'
if (Test-Path $iconsDir) {
    Get-ChildItem -Path $iconsDir -File | ForEach-Object {
        $n = $_.Name.ToLowerInvariant()
        $isIcon = ($n -match 'icon') -or ($n -match 'logo') -or ($n -match 'service-move-arrow')
        if (-not $isIcon) {
            Add-Fail ("assets/icons/{0} is not a dedicated icon; move to media/ or the correct category folder" -f $_.Name)
        }
    }
}

# 8) Flag legacy numbered asset names still referenced in app/views/css
$codeHitPatterns = @(
    'client-logo-\d',
    'dev-icon-\d',
    'market-icon-\d',
    'assets/team/team-\d',
    'assets/media/market-\d',
    'faq-gif\.gif',
    'background_about\.png',
    'cover_banner\.png'
)
foreach ($file in $codeFiles) {
    $text = [IO.File]::ReadAllText($file.FullName)
    $rel = ($file.FullName.Substring($root.Length + 1) -replace '\\', '/')
    foreach ($pat in $codeHitPatterns) {
        if ($text -match $pat) {
            Add-Fail ("{0} still references legacy asset name pattern /{1}/" -f $rel, $pat)
        }
    }
}

# 9) Every <img> in Blade must have a non-empty alt= (attribute present + not alt="")
# Normalize Blade "=>" so it is not mistaken for the tag's closing ">"
$viewFiles = @(Get-ChildItem (Join-Path $root 'resources\views') -Recurse -Include *.blade.php -File -ErrorAction SilentlyContinue)
foreach ($file in $viewFiles) {
    $text = [IO.File]::ReadAllText($file.FullName)
    $rel = ($file.FullName.Substring($root.Length + 1) -replace '\\', '/')
    # Blade operators "=>" and "->" both contain ">" and break naive tag parsing
    $normalized = ($text -replace '=>', '==') -replace '->', '--'
    $imgMatches = [regex]::Matches($normalized, '<img\b[\s\S]*?>', 'IgnoreCase')
    $index = 0
    foreach ($m in $imgMatches) {
        $index++
        $tag = $m.Value
        if ($tag -notmatch '\balt\s*=') {
            Add-Fail ("{0} <img> #{1} is missing an alt attribute" -f $rel, $index)
            continue
        }
        # Fail hard-coded empty alt=""; allow Blade expressions like alt="{{ ... }}"
        if ($tag -match '\balt\s*=\s*""' -or $tag -match "\balt\s*=\s*''") {
            Add-Fail ("{0} <img> #{1} has an empty alt attribute; use a descriptive sentence" -f $rel, $index)
        }
        if ($tag -notmatch '\btitle\s*=') {
            Add-Fail ("{0} <img> #{1} is missing a title attribute (mirror alt)" -f $rel, $index)
        } elseif ($tag -match '\btitle\s*=\s*""' -or $tag -match "\btitle\s*=\s*''") {
            Add-Fail ("{0} <img> #{1} has an empty title attribute; mirror the alt text" -f $rel, $index)
        }
    }
}

Write-Host ''
if ($cleaned.Count -gt 0) {
    Write-Host ("Cleaned {0} item(s)." -f $cleaned.Count)
}
if ($failed.Count -gt 0) {
    Write-Host ("Verification failed with {0} issue(s)." -f $failed.Count) -ForegroundColor Red
    exit 1
}

Write-Host 'Verification passed. Conventions look clean.' -ForegroundColor Green
exit 0
