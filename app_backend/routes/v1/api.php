<?php

use App\Http\Controllers\V1\ExecutionController;
use App\Http\Controllers\V1\ModuleController;
use App\Http\Controllers\V1\PingController;
use App\Http\Controllers\V1\TenantController;
use App\Http\Controllers\V1\TenantUserController;
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

    $router->middleware('api')->group(function (Router $router) {
        $router->get('/logout', [TokenController::class, 'logout'])->name('logout');

        $router->get('/me', [UserController::class, 'show'])->name('me');

        $router->group(['prefix' => '/tenants'], function (Router $router) {
            $router->get('/', [TenantController::class, 'index'])->name('tenants.index');
            $router->post('/', [TenantController::class, 'store'])->name('tenants.store');

            $router->group(['prefix' => '/{tenant}'], function (Router $router) {
                $router->get('/', [TenantController::class, 'show'])->name('tenants.show');
                $router->put('/', [TenantController::class, 'update'])->name('tenants.update');
                $router->delete('/', [TenantController::class, 'delete'])->name('tenants.delete');

                $router->group(['prefix' => '/users'], function (Router $router) {
                    $router->get('/', [TenantUserController::class, 'index'])->name('users.tenants.index');
                    $router->post('/', [TenantUserController::class, 'attach'])->name('users.tenants.attach');

                    $router->group(['prefix' => '/{user}'], function (Router $router) {
                        $router->patch('/', [TenantUserController::class, 'updateRole'])
                            ->name('users.tenants.role.update');
                        $router->delete('/', [TenantUserController::class, 'detach'])
                            ->name('users.tenants.detach');
                    });
                });

                $router->group(['prefix' => '/modules'], function (Router $router) {
                    $router->get('/', [ModuleController::class, 'index'])->name('tenants.modules.index');
                    $router->post('/contract', [ModuleController::class, 'contract'])->name('tenants.modules.contract');

                    $router->group(['prefix' => '/{module}'], function (Router $router) {
                        $router->get('/', [ModuleController::class, 'show'])->name('tenants.modules.show');
                        $router->post('/attach-users', [ModuleController::class, 'attachUsers'])
                            ->name('tenants.modules.attach-users');
                        $router->post('/detach-users', [ModuleController::class, 'detachUsers'])
                            ->name('tenants.modules.detach-users');

                        $router->post('/execute', ExecutionController::class)->name('tenants.modules.execute');
                    });
                });

                $router->group(['prefix' => '/tokens'], function (Router $router) {
                    $router->get('/', [TokenController::class, 'index'])->name('tenants.tokens.index');
                    $router->post('/', [TokenController::class, 'store'])->name('tenants.tokens.store');
                });
            });
        });
    });
});
