<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

foreach (['/tmp/storage/framework/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions'] as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0755, true);
    }
}

foreach ([
    'APP_SERVICES_CACHE' => '/tmp/storage/framework/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/storage/framework/cache/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/storage/framework/cache/config.php',
    'APP_ROUTES_CACHE' => '/tmp/storage/framework/cache/routes.php',
    'APP_EVENTS_CACHE' => '/tmp/storage/framework/cache/events.php',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
] as $key => $val) {
    putenv("{$key}={$val}");
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
}

(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
