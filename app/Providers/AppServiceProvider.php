<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\AlbumRepositoryInterface;
use App\Repositories\Eloquent\AlbumRepository;
use App\Repositories\Contracts\SongRepositoryInterface;
use App\Repositories\Eloquent\SongRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

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
    public function boot(Request $request): void
    {
        if ($request->server->has('HTTP_X_ORIGINAL_HOST')) {
            $scheme = $request->server->get('HTTP_X_FORWARDED_PROTO', 'https');
            $host = $request->server->get('HTTP_X_ORIGINAL_HOST');
            URL::forceRootUrl("{$scheme}://{$host}");
        }
    }
}


