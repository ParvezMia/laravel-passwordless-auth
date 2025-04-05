<?php

namespace Jea\PasswordlessAuth;

use Illuminate\Support\ServiceProvider;

class PasswordlessAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/passwordless-auth.php' => config_path('passwordless-auth.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations/create_login_tokens_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_login_tokens_table.php'),
        ], 'migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/passwordless-auth'),
        ], 'views');

        // Publish routes
        $this->publishes([
            __DIR__.'/../routes/passwordless-auth.php' => base_path('routes/passwordless-auth.php'),
        ], 'routes');

        // Publish email-related files
        $this->publishes([
            __DIR__.'/../src/Notifications' => app_path('Notifications/Passwordless'),
            __DIR__.'/../resources/views/emails' => resource_path('views/vendor/passwordless-auth/emails'),
        ], 'email');

        // Publish controllers
        $this->publishes([
            __DIR__.'/../src/Http/Controllers' => app_path('Http/Controllers/Passwordless'),
        ], 'controllers');

        // Publish models
        $this->publishes([
            __DIR__.'/../src/Models' => app_path('Models/Passwordless'),
        ], 'models');

        // Publish all components at once
        $this->publishes([
            __DIR__.'/../config/passwordless-auth.php' => config_path('passwordless-auth.php'),
            __DIR__.'/../database/migrations/create_login_tokens_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_login_tokens_table.php'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/passwordless-auth'),
            __DIR__.'/../routes/passwordless-auth.php' => base_path('routes/passwordless-auth.php'),
            __DIR__.'/../src/Notifications' => app_path('Notifications/Passwordless'),
            __DIR__.'/../src/Http/Controllers' => app_path('Http/Controllers/Passwordless'),
            __DIR__.'/../src/Models' => app_path('Models/Passwordless'),
        ], 'all');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Load views - ensure this is correctly loading the views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'passwordless-auth');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../config/passwordless-auth.php', 'passwordless-auth');
    }
}
