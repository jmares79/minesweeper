<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GridServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind('Service\Grid\GridService', function ($app) {
            return new GridService();
        });
    }
}
