<?php

use App\Http\Controllers\V1\PingController;
use App\Http\Controllers\V1\TokenController;
use Illuminate\Routing\Router;

/* @var $router Router */

$loginLimiter = config('app.rate_limit.login');

$router->name('v1.')->group(function (Router $router) use ($loginLimiter) {
    $router->get('/ping', [PingController::class, 'show'])->name('ping.show');

    $router->middleware(['guest'])->group(function (Router $router) use ($loginLimiter) {
        $router->middleware(["throttle:{$loginLimiter},1"])->group(function (Router $router) {
            $router->post('/login', [TokenController::class, 'login'])->name('login');
        });
    });

    $router->middleware('jwt')->group(function (Router $router) {
        $router->get('/logout', [TokenController::class, 'logout'])->name('logout');
    });
});
