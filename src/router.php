<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve assets from src/assets/
if (str_starts_with($uri, '/assets/')) {
    $file = '/app/src' . $uri;
    if (file_exists($file) && is_file($file)) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimeTypes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'webp'  => 'image/webp',
            'svg'   => 'image/svg+xml',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'ico'   => 'image/x-icon',
            'woff2' => 'font/woff2',
            'woff'  => 'font/woff',
        ];
        header('Content-Type: ' . ($mimeTypes[$ext] ?? mime_content_type($file)));
        readfile($file);
        exit;
    }
    http_response_code(404);
    exit;
}

// Serve other static files directly (audit sub-pages, etc.)
if ($uri !== '/' && file_exists('/app' . $uri) && !is_dir('/app' . $uri)) {
    return false;
}

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/routes.php';

$routes = getRoutes();

if (!isset($routes[$uri])) {
    http_response_code(404);
    echo '<h1>404 Not found</h1><p>' . htmlspecialchars($uri) . '</p>';
    exit;
}

$ctx = $routes[$uri];
$twig = createTwig($ctx['locale']);

echo $twig->render($ctx['template'], $ctx);
