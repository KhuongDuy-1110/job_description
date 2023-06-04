<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Api\Eloquent\BaseRepository;
use App\Repositories\Api\Eloquent\UserRepository;
use App\Repositories\Api\EloquentRepositoryInterface;
use App\Repositories\Api\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
