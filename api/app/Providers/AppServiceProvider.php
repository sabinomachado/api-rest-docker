<?php

namespace App\Providers;

use App\Repositories\Crud\CrudRepository;
use App\Repositories\Crud\EloquentCrudRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \Faker\Generator::class,
            function () {
                return \Faker\Factory::create('pt_BR');
            }
        );
        $this->app->register(ApiResponseServiceProvider::class);
        $this->app->bind(EloquentCrudRepository::class, CrudRepository::class);
        $this->app->bind('App\Contracts\Query\FilterContract', 'App\Services\Query\Filter');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
