<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Api\Eloquent\BaseRepository;
use App\Repositories\Api\EloquentRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);                                                                                                                                                                                                                                                         
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
