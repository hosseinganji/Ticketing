<?php

namespace App\Providers;

use App\Services\Webservice\HttpWebserviceClient;
use App\Services\Webservice\WebserviceClientInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(WebserviceClientInterface::class, HttpWebserviceClient::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
