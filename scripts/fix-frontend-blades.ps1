$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent $PSScriptRoot
$viewsDir = Join-Path $root 'resources\views'

$routeMap = [ordered]@{
  'href="/"' = 'href="{{ route(''home'') }}"'
  'href="/about-us"' = 'href="{{ route(''about-us'') }}"'
  'href="/contact-us"' = 'href="{{ route(''contact-us'') }}"'
  'href="/contact-us/#contact-id"' = 'href="{{ route(''contact-us'') }}#contact-id"'
  'href="/services"' = 'href="{{ route(''services'') }}"'
  'href="/product"' = 'href="{{ route(''product'') }}"'
  'href="/blogs"' = 'href="{{ route(''blogs'') }}"'
  'href="/industries"' = 'href="{{ route(''industries'') }}"'
  'href="/service/web-development-services"' = 'href="{{ route(''service.show'', ''web-development-services'') }}"'
  'href="/service/custom-crm-development"' = 'href="{{ route(''service.show'', ''custom-crm-development'') }}"'
  'href="/service/enterprise-software-solutions"' = 'href="{{ route(''service.show'', ''enterprise-software-solutions'') }}"'
  'href="/service/e-commerce-development"' = 'href="{{ route(''service.show'', ''e-commerce-development'') }}"'
  'href="/industries/healthcare"' = 'href="{{ route(''industries.healthcare'') }}"'
  'href="/industries/it-software-solutions-for-startups"' = 'href="{{ route(''industries.it-software-solutions-for-startups'') }}"'
  'href="/industries/finance-banking-software-development"' = 'href="{{ route(''industries.finance-banking-software-development'') }}"'
  'href="/industries/retail-ecommerce-solutions"' = 'href="{{ route(''industries.retail-ecommerce-solutions'') }}"'
  'href="/industries/logistics-supply-chain-apps"' = 'href="{{ route(''industries.logistics-supply-chain-apps'') }}"'
  'href="/industries/education-elearning-platforms"' = 'href="{{ route(''industries.education-elearning-platforms'') }}"'
  'href="/blog/digital-strategy-that-creates-value"' = 'href="{{ route(''blog.show'', ''digital-strategy-that-creates-value'') }}"'
  'href="/blog/product-data-customer-experiences"' = 'href="{{ route(''blog.show'', ''product-data-customer-experiences'') }}"'
  'href="/blog/digital-workflows-teams-use"' = 'href="{{ route(''blog.show'', ''digital-workflows-teams-use'') }}"'
  'href="/blog/ai-powered-software-development-2026"' = 'href="{{ route(''blog.show'', ''ai-powered-software-development-2026'') }}"'
  'href="/blog/choosing-the-right-tech-stack"' = 'href="{{ route(''blog.show'', ''choosing-the-right-tech-stack'') }}"'
  'href="/blog/ux-principles-that-drive-conversions"' = 'href="{{ route(''blog.show'', ''ux-principles-that-drive-conversions'') }}"'
}

$blogRoutePatterns = @{
  'href="/blog/digital-strategy-that-creates-value"' = 'blog.show'
  'href="/blog/product-data-customer-experiences"' = 'blog.show'
  'href="/blog/digital-workflows-teams-use"' = 'blog.show'
  'href="/blog/ai-powered-software-development-2026"' = 'blog.show'
  'href="/blog/choosing-the-right-tech-stack"' = 'blog.show'
  'href="/blog/ux-principles-that-drive-conversions"' = 'blog.show'
}

$files = Get-ChildItem -Path $viewsDir -Recurse -Include *.blade.php -File

foreach ($file in $files) {
  $text = [IO.File]::ReadAllText($file.FullName)
  $original = $text

  foreach ($entry in $routeMap.GetEnumerator()) {
    $text = $text.Replace($entry.Key, $entry.Value)
  }

  # Dynamic blog links
  $text = [regex]::Replace($text, 'href="/blog/\{\{\s*\$post\[''slug''\]\s*\}\}"', 'href="{{ route(''blog.'' . $post[''slug'']) }}"')
  $text = [regex]::Replace($text, 'href="/blog/\{\{\s*\$item\[''slug''\]\s*\}\}"', 'href="{{ route(''blog.'' . $item[''slug'']) }}"')

  # Fix malformed background-image style attributes from import
  $text = [regex]::Replace($text, "url\('\{\{ asset\('([^']+)'\) \}\}'\) bg-cover bg-[^""']+", "url('{{ asset('$1') }}')")

  # Remove empty guard blocks from partial imports
  $text = [regex]::Replace($text, '@if \(empty\(\$service\) \|\| !is_array\(\$service\)\)[\s\S]*?@endif\s*', '', 'IgnoreCase')
  $text = [regex]::Replace($text, '@if \(empty\(\$industry\) \|\| !is_array\(\$industry\)\)[\s\S]*?@endif\s*', '', 'IgnoreCase')

  # Fix images/ leftovers in blades
  $text = $text -replace "/images/agile-icon-1\.svg", "assets/icons/agile-icon-1.svg"
  $text = $text -replace "'/images/", "'assets/media/"
  $text = $text -replace '"/images/', '"assets/media/'

  # SEO dynamic titles for detail pages
  if ($file.Name -eq 'service-detail.blade.php') {
    $text = $text -replace 'title="Service \| Suave Creators"', ':title="$seoTitle"'
    $text = $text -replace 'description="Suave Creators service details\."', ':description="$seoDescription"'
    $text = $text -replace 'og-title="Service \| Suave Creators"', ':og-title="$seoTitle"'
    $text = $text -replace 'og-description="Suave Creators service details\."', ':og-description="$seoDescription"'
  }
  if ($file.Name -eq 'industry-detail.blade.php') {
    $text = $text -replace 'title="Industry \| Suave Creators"', ':title="$seoTitle"'
    $text = $text -replace 'description="Suave Creators industry solutions\."', ':description="$seoDescription"'
    $text = $text -replace 'og-title="Industry \| Suave Creators"', ':og-title="$seoTitle"'
    $text = $text -replace 'og-description="Suave Creators industry solutions\."', ':og-description="$seoDescription"'
  }
  if ($file.Name -eq 'single-blog.blade.php') {
    $text = $text -replace 'title="Blog \| Suave Creators"', ':title="$seoTitle"'
    $text = $text -replace 'description="Suave Creators blog article\."', ':description="$seoDescription"'
    $text = $text -replace 'og-title="Blog \| Suave Creators"', ':og-title="$seoTitle"'
    $text = $text -replace 'og-description="Suave Creators blog article\."', ':og-description="$seoDescription"'
  }

  # Consultation team alt/title defaults
  $consultationAlts = @{
    'consultation-team-member-1.png' = 'Suave Creators UI UX designer for custom software projects'
    'consultation-team-member-2.png' = 'Suave Creators software engineer for web development services'
    'consultation-team-leader.png' = 'Suave Creators project lead for enterprise software solutions'
    'consultation-designer.png' = 'Suave Creators product designer for CRM development'
    'consultation-team-lead.png' = 'Suave Creators team lead for digital product delivery'
    'consultation-team-collaborating.png' = 'Suave Creators team collaborating on software development'
  }
  foreach ($entry in $consultationAlts.GetEnumerator()) {
    $pattern = "src=`"\{\{ asset\('assets/team/$($entry.Key)'\) \}\}`" alt=`"`""
    $replacement = "src=`"{{ asset('assets/team/$($entry.Key)') }}`" alt=`"$($entry.Value)`" title=`"$($entry.Value)`""
    $text = $text.Replace($pattern, $replacement)
  }

  # Generic empty alt on imgs - use aria-hidden decorative fallback
  $text = [regex]::Replace($text, '(<img\b[^>]*)\balt=""([^>]*aria-hidden="true"[^>]*>)', '$1alt="Decorative graphic for Suave Creators website"$2 title="Decorative graphic for Suave Creators website"$2', 'IgnoreCase')
  $text = [regex]::Replace($text, '(<img\b(?![^>]*\btitle=)[^>]*)\balt="([^"]+)"', '$1alt="$2" title="$2"', 'IgnoreCase')

  if ($text -ne $original) {
    $utf8 = New-Object System.Text.UTF8Encoding $false
    [IO.File]::WriteAllText($file.FullName, $text, $utf8)
    Write-Output "Fixed $($file.Name)"
  }
}

Write-Output 'Blade post-processing complete.'
