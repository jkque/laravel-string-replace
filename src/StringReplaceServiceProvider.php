<?php

namespace Jkque\StringReplace;

use Illuminate\Support\ServiceProvider;
use Jkque\StringReplace\StringReplace;

class StringReplaceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('string-replace.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                StringReplaceCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'string-replace');

        // Register the main class to use with the facade
        $this->app->singleton('string-replace', function () {
            return new StringReplace;
        });
    }
}
