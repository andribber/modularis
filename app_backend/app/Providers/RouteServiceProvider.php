<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    final public const HOME = '/home';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapAppRoutes();
        });
    }

    protected function configureRateLimiting(): void
    {
        /** @var Router $router */
        $router = app()->make('router');

        $throttleMiddleware = $this->getThrottleMiddlewareClass();
        $router->aliasMiddleware('throttle', $throttleMiddleware);

        foreach (config('app.rate_limit') as $group => $value) {
            RateLimiter::for(
                $group,
                fn (Request $request) => Limit::perMinute($value)
                    ->by($request->user()?->id ?? $request->ip()),
            );
        }
    }

    protected function getThrottleMiddlewareClass(): string
    {
        return config('cache.default') === 'redis' ? ThrottleRequestsWithRedis::class : ThrottleRequests::class;
    }

    protected function mapAppRoutes(): void
    {
        $domain = sprintf('app.%s', config('app.url'));

        Route::middleware('api')
            ->domain($domain)
            ->group(base_path('routes/v1/app.php'));
    }

    protected function mapApiRoutes(): void
    {
        $domain = sprintf('api.%s', config('app.url'));

        Route::middleware('api')
            ->prefix('v1')
            ->domain($domain)
            ->group(base_path('routes/v1/api.php'));
    }
}
