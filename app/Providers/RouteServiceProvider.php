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
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';
    public const LOGIN = '/login';
    public const GOPANEL_LOGIN = '/gopanel/login';
    public const GOPANEL_HOME = '/gopanel/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers\\V1';
    protected $namespaceAdmin = 'App\\Http\\Controllers\\V1\Admin';
    protected $namespaceCurl = 'App\\Http\\Controllers\\V1\Curl';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $versions = config('services.versions');

        $this->routes(function () use ($versions) {

            foreach ($versions as $version) {
                $this->namespace = "App\\Http\\Controllers\\" . ucfirst($version) . "\\";

                Route::prefix("api/customer/$version")
                    ->middleware(['customer', 'api.json'])
                    ->namespace($this->namespace . '\\Customer')
                    ->group(base_path("routes/" . ucfirst($version) . "/customer.php"));
            }


            Route::prefix('curl')
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/curl.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            // Route::middleware(['web'])
            //     ->namespace($this->namespaceAdmin)
            //     ->name('admin.')
            //     ->prefix('gopanel')
            //     ->group(base_path('routes/admin.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('customer', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('driver', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
