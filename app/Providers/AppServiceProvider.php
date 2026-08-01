<?php

namespace App\Providers;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(\App\Interfaces\Repositories\ProjectRepositoryInterface::class, \App\Repositories\ProjectRepository::class);
        $this->app->bind(\App\Interfaces\Repositories\TaskRepositoryInterface::class, \App\Repositories\TaskRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
