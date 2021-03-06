<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\RepositoryInterface::class,
            \App\Repositories\EloquentReposiotry::class,
            \App\Repositories\WorkspaceRepository::class,
            \App\Repositories\TypeRepository::class,
            \App\Repositories\TeamRepository::class,
            \App\Repositories\BatchRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Subject\SubjectRepositoryInterface::class,
            \App\Repositories\Subject\SubjectEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Reviews\ReviewRepositoryInterface::class,
            \App\Repositories\Reviews\ReviewEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Roles\RoleRepositoryInterface::class,
            \App\Repositories\Roles\RoleEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Users\UserRepositoryInterface::class,
            \App\Repositories\Users\UserEloquentRepository::class
        );
    }
}
