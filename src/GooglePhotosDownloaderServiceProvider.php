<?php

namespace Vigurdev\GooglePhotosDownloader;

use Illuminate\Support\ServiceProvider;

class GooglePhotosDownloaderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes/web.php';
        $this->app->make('Vigurdev\GooglePhotosDownloader\GooglePhotosDownloaderController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
