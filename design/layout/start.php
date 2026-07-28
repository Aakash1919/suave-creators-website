<?php
$pageTitle = $pageTitle ?? 'Suave Creators';
$pageDescription = $pageDescription ?? '';
$bodyClass = $bodyClass ?? 'min-h-screen bg-white font-sans text-slate-900';
$useHeroBackground = $useHeroBackground ?? true;
$heroBackgroundImage = $heroBackgroundImage ?? '/images/cover_banner.png';
$extraStylesheets = $extraStylesheets ?? [];
$mainClass = $mainClass ?? 'site-main';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle ?? 'Suave Creators') ?></title>
  <?php if (!empty($pageDescription)): ?>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ["PP Mori", "Roboto Flex", "ui-sans-serif", "system-ui", "sans-serif"],
          },
        },
      },
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="/css/style.css?v=<?= filemtime(__DIR__ . '/../css/style.css') ?>">
  <?php foreach ($extraStylesheets as $stylesheet): ?>
    <?php
      $stylesheetHref = (string) $stylesheet;
      if (str_starts_with($stylesheetHref, '/css/')) {
        $stylesheetPath = __DIR__ . '/..' . parse_url($stylesheetHref, PHP_URL_PATH);
        if (is_file($stylesheetPath)) {
          $stylesheetHref .= (str_contains($stylesheetHref, '?') ? '&' : '?') . 'v=' . filemtime($stylesheetPath);
        }
      }
    ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($stylesheetHref) ?>">
  <?php endforeach; ?>
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
  <div class="relative w-full overflow-hidden <?= $useHeroBackground ? 'bg-[#00003f]' : 'bg-white' ?>">
    <?php if ($useHeroBackground && $heroBackgroundImage): ?>
      <div class="pointer-events-none absolute inset-x-0 top-0 z-0 h-[min(100%,920px)] lg:inset-0 lg:h-auto" aria-hidden="true">
        <img src="<?= htmlspecialchars((string) $heroBackgroundImage) ?>" alt="" class="absolute inset-0 h-full w-full object-cover object-top">
        <?php if ($heroBackgroundImage === '/images/cover_banner.png'): ?>
          <img src="/images/hero_Pattern(left).svg" alt="" class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-soft-light">
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="relative z-10">
      <?php require __DIR__ . '/../partials/topbar.php'; ?>
      <?php require __DIR__ . '/../partials/header.php'; ?>

      <!--- Page Content Starts Here -->
      <main class="<?= htmlspecialchars($mainClass) ?>">