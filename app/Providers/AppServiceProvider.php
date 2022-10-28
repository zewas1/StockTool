<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client();
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
