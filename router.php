<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing files directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

$routes = [
    '#^/tag/([^/]+)/?$#' => 'tag.php?tag=$1',
    '#^/tag/([^/]+)/(\d+)/?$#' => 'tag.php?tag=$1&page=$2',
    '#^/post/([^/]+)/?$#' => 'post.php?slug=$1',
    '#^/page/([^/]+)/?$#' => 'page.php?slug=$1',
    '#^/tags#' => 'tags.php',
];

foreach ($routes as $pattern => $handler) {
    if (preg_match($pattern, $uri, $matches)) {
        $_GET = array_merge($_GET, $_REQUEST);
        array_shift($matches);
        $parsedHandler = parse_url($handler);
        $query = $parsedHandler['query'] ?? '';
        if ($query !== '') {
            $query = preg_replace_callback('/\$(\d+)/', function($m) use ($matches) {
                return isset($matches[$m[1] - 1]) ? $matches[$m[1] - 1] : '';
            }, $query);
            parse_str($query, $params);
            $_GET = array_merge($_GET, $params);
        }
        $file = __DIR__ . '/' . ($parsedHandler['path'] ?? '');
        if (file_exists($file)) {
            require $file;
            exit;
        } else {
            http_response_code(404);
            echo "Error: File $file not found.";
            exit;
        }
    }
}

// If no route matches, serve index.php
$indexFile = __DIR__ . '/index.php';
if (file_exists($indexFile)) {
    require $indexFile;
} else {
    http_response_code(404);
    echo "Error: index.php not found.";
}

