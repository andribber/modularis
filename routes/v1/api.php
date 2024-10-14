<?php

use App\Http\Controllers\V1\PingController;
use App\Http\Controllers\V1\TenantController;
use App\Http\Controllers\V1\TokenController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Routing\Router;

/* @var $router Router */

$loginLimiter = config('app.rate_limit.login');

$router->name('v1.')->group(function (Router $router) use ($loginLimiter) {
    $router->get('/ping', [PingController::class, 'show'])->name('ping.show');

    $router->middleware(['guest'])->group(function (Router $router) use ($loginLimiter) {
        $router->middleware(["throttle:{$loginLimiter},1"])->group(function (Router $router) {
            $router->post('/login', [TokenController::class, 'login'])->name('login');

            $router->post('/register', [TokenController::class, 'register'])->name('register');
        });
    });

    $router->middleware('jwt')->group(function (Router $router) {
        $router->get('/logout', [TokenController::class, 'logout'])->name('logout');

        $router->group(['prefix' => '/me'], function (Router $router) {
            $router->get('/', [UserController::class, 'show'])->name('me.user');
        });

        $router->group(['prefix' => '/tenants'], function (Router $router) {
            $router->get('/', [TenantController::class, 'index'])->name('tenants.index');
            $router->post('/', [TenantController::class, 'store'])->name('tenants.store');

            $router->group(['prefix' => '/{tenant}'], function (Router $router) {
                $router->get('/', [TenantController::class, 'show'])->name('tenants.show');
                $router->put('/', [TenantController::class, 'update'])->name('tenants.update');
                $router->delete('/', [TenantController::class, 'delete'])->name('tenants.delete');

                $router->group(['prefix' => '/tokens'], function (Router $router) {
                    $router->get('/', [TokenController::class, 'index'])->name('tenants.tokens.index');
                    $router->post('/', [TokenController::class, 'store'])->name('tenants.tokens.store');
                });
            });
        });
    });
});
