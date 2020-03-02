<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MultiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['request']->server->set('HTTPS','on');
    }
}
