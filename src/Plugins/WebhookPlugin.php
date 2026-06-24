<?php

declare(strict_types=1);

namespace Panelis\Webhook\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;

class WebhookPlugin implements Plugin
{
    public function getId(): string
    {
        return 'webhook';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}
}
