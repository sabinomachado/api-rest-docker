<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function map()
    {
        $this->mapAuthRoutes();
    }

    protected function mapAuthRoutes()
    {
        Route::prefix('api/v1/auth')
            ->middleware('auth.apikey')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/auth/routes.php'));
    }
}
