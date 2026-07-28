<?php
/**
 * Router for PHP built-in server.
 * Start with: php -S localhost:8000 router.php
 * Or double-click start-server.bat
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');

// Normalize trailing slashes (keep "/" as-is)
if ($uri !== '/' && str_ends_with($uri, '/')) {
  $uri = rtrim($uri, '/') ?: '/';
}

$file = __DIR__ . $uri;

// Serve real files (CSS, images, existing .php paths) as-is
if ($uri !== '/' && is_file($file)) {
  return false;
}

$routes = [
  '/' => 'index.php',
  '/industry' => 'industry.php',
  '/industry.php' => 'industry.php',
  '/about-us' => 'about-us.php',
  '/about-us.php' => 'about-us.php',
  '/product' => 'product.php',
  '/product.php' => 'product.php',
  '/contact-us' => 'contact-us.php',
  '/contact-us.php' => 'contact-us.php',
  '/blogs' => 'blogs.php',
  '/blogs.php' => 'blogs.php',
  '/services' => 'services.php',
  '/services.php' => 'services.php',
  '/privacy-policy' => 'privacy-policy.php',
  '/privacy-policy.php' => 'privacy-policy.php',
  '/terms-and-conditions' => 'terms-and-conditions.php',
  '/terms-and-conditions.php' => 'terms-and-conditions.php',
];

if (isset($routes[$uri])) {
  require __DIR__ . '/' . $routes[$uri];
  return true;
}

if (preg_match('#^/industries/([a-z0-9\-]+)$#', $uri, $matches)) {
  $page = __DIR__ . '/industries/' . $matches[1] . '.php';
  if (is_file($page)) {
    require $page;
    return true;
  }
}

if (preg_match('#^/service/([a-z0-9\-]+)$#', $uri, $matches)) {
  $page = __DIR__ . '/service/' . $matches[1] . '.php';
  if (is_file($page)) {
    require $page;
    return true;
  }
}

if (preg_match('#^/blog/([a-z0-9\-]+)$#', $uri, $matches)) {
  $slug = $matches[1];
  require __DIR__ . '/partials/single-blog.php';
  return true;
}

http_response_code(404);
echo '404 Not Found';
return true;
