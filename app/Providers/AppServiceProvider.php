<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\AlbumRepositoryInterface;
use App\Repositories\Eloquent\AlbumRepository;
use App\Repositories\Contracts\SongRepositoryInterface;
use App\Repositories\Eloquent\SongRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        AlbumRepositoryInterface::class,
        AlbumRepository::class,
        SongRepositoryInterface::class,
        SongRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}


