<?php

declare(strict_types=1);

namespace Panelis\Webhook\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/webhook.php', 'webhook');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/webhook.php' => config_path('webhook.php'),
        ], 'webhook-config');

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'webhook-migrations');

        Route::prefix(Config::get('webhook.prefix'))
            ->group(__DIR__.'/../../routes/web.php');
    }
}
