<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (($_SERVER['REQUEST_URI'] ?? '') === '/healthz') {
    header('Content-Type: application/json');
    echo '{"status":"ok"}';
    return;
}

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
