<?php

namespace AgenciaEgo\Resizer;

use Illuminate\Support\ServiceProvider;
use AgenciaEgo\Resizer\Commands\ClearResizerCache;

class ResizerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'agenciaego');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'agenciaego');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/resizer.php' => config_path('resizer.php'),
            ], 'resizer.config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/agenciaego'),
            ], 'resizer.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/agenciaego'),
            ], 'resizer.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/agenciaego'),
            ], 'resizer.views');*/

            // Registering package commands.
            $this->commands([
                ClearResizerCache::class
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/resizer.php', 'resizer');

        // Register the service the package provides.
        $this->app->singleton('resizer', function ($app) {
            return new Resizer;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['resizer'];
    }
}