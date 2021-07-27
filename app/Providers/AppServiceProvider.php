<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Interfaces\RepositoryInterface', 'App\Repositories\Repository');
        $this->app->singleton('App\Interfaces\UsuarioRepositoryInterface', 'App\Repositories\UsuarioRepository');
        $this->app->singleton('App\Interfaces\TaskRepositoryInterface', 'App\Repositories\TaskRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
