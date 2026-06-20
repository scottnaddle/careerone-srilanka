<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing static files from public/ directly
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// All other requests → Laravel (document root stays at project root)
require_once __DIR__ . '/public/index.php';
