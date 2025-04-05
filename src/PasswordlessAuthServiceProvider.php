<?php

namespace ParvezMia\LaravelPasswordlessAuth;

use Illuminate\Support\ServiceProvider;

class PasswordlessAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/passwordless-auth.php' => config_path('passwordless-auth.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/passwordless-auth'),
        ], 'views');

        // Publish routes
        $this->publishes([
            __DIR__.'/../routes/passwordless-auth.php' => base_path('routes/passwordless-auth.php'),
        ], 'routes');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'passwordless-auth');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/passwordless-auth.php', 'passwordless-auth'
        );
    }
}
