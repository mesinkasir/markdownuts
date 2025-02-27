<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$basePath = '/pushw';

if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
$uri = rtrim($uri, '/');
$routes = [
    '/post/([^/]+)' => ['file' => 'post.php', 'param' => 'slug'],
    '/page/([^/]+)' => ['file' => 'page.php', 'param' => 'slug'],
    '/tag/([^/]+)' => ['file' => 'tag.php', 'param' => 'tag'],
    '/tags' => ['file' => 'tags.php']
];

foreach ($routes as $pattern => $route) {
    if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
        if (isset($matches[1]) && isset($route['param'])) {
            $_GET[$route['param']] = $matches[1];
        }
        require __DIR__ . '/../' . $route['file'];
        exit;
    }
}

if ($uri !== '' && file_exists(__DIR__ . '/../' . ltrim($uri, '/'))) {
    return false;
}

return true;
