<?php

namespace trevormh\LaravelStartupHelper;

use Illuminate\Support\ServiceProvider;

class StartupHelperServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider
     * @return void
     */
    public function register() : void
    {
        $this->app->singleton('trevormh\LaravelStartupHelper\StartupFactory', function() {
            return new StartupFactory();
        });
    }
}