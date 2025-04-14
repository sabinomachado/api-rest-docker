<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class DynamicRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapDynamicRoutes();
        $this->mapWebHookRoutes();
        $this->mapHealthCheckRoutes();
    }

    protected function mapDynamicRoutes()
    {
        foreach (glob(base_path('routes/api/*.php')) as $routeFile) {
            Route::prefix('api/v1')
                ->middleware(['api', 'auth:sanctum'])
                ->namespace($this->namespace)
                ->group($routeFile);
        }
    }

    protected function mapWebHookRoutes()
    {
        foreach (glob(base_path('routes/webhook/*.php')) as $routeFile) {
            Route::prefix('webhook/v1')
                ->namespace($this->namespace)
                ->group($routeFile);
        }
    }

    protected function mapHealthCheckRoutes()
    {
        foreach (glob(base_path('routes/health/*.php')) as $routeFile) {
            Route::prefix('health')
                ->namespace($this->namespace)
                ->group($routeFile);
        }
    }
}
