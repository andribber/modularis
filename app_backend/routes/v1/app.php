<?php

use App\Http\Controllers\V1\PingController;
use Illuminate\Routing\Router;

/* @var $router Router */

$router->get('/ping', [PingController::class, 'show'])->name('ping.show');
