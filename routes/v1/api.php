<?php

use App\Http\Controllers\V1\PingController;
use Illuminate\Routing\Router;

/* @var $router Router */

$router->name('v1.')->group(function (Router $router) {
    $router->get('/ping', [PingController::class, 'show'])->name('ping.show');
});
