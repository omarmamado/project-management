<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $version     = strtolower(request()->header('api-version') ?? request()->segment(2) ?? env('API_VERSION'));
            $middlewares = ['api'];
            $api_files   = [
                "v1" => [
                    ['file' => 'user', 'prefix' => 'user'],
                ]
            ];
            // API Routes
            if (isset($api_files[$version])) {
                foreach ($api_files[$version] as $file) {
                    $middleware = isset($file['middleware']) ? array_merge($middlewares, (array)$file['middleware']) : $middlewares;
                    Route::middleware($middleware)
                        ->prefix("api/$version/{$file['prefix']}")
                        ->group(base_path("routes/api/$version/{$file['file']}.php"));
                }
            }

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
