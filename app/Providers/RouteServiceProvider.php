<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    public const NAMESPACE = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->bindModels();

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this::NAMESPACE)
                ->group(base_path('routes/web.php'));

            Route::middleware(['web','role:admin','auth','prevent-back'])
                ->prefix('admin')
                ->as('admin.')
                ->namespace($this::NAMESPACE.'\Admin')
                ->group(base_path('routes/admin.php'));
            Route::middleware(['web','role:manager','auth','prevent-back'])
                ->prefix('manager')
                ->as('manager.')
                ->namespace($this::NAMESPACE.'\Manager')
                ->group(base_path('routes/manager.php'));
            Route::middleware(['web','role:member','auth','prevent-back'])
                ->prefix('member')
                ->as('member.')
                ->namespace($this::NAMESPACE.'\Member')
                ->group(base_path('routes/member.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    protected function bindModels()
    {
        // Define route model binding for the User model
        Route::bind('user', function ($value) {
            // Retrieve the User model, including soft-deleted ones
            return User::withTrashed()->findOrFail($value);
        });

        // Define route model binding for the Project model
        Route::bind('project', function ($value) {
            // Retrieve the Project model, including soft-deleted ones
            return Project::withTrashed()->findOrFail($value);
        });
    }
}
