<?php

declare(strict_types=1);

namespace Panelis\Webhook\Webhooks;

use Panelis\Webhook\Contracts\Webhook;

class PingWebhook implements Webhook
{
    public function validate(): void {}

    public function handle(): mixed
    {
        return response()->json([
            'message' => 'pong',
            'timestamp' => now()->timestamp,
        ]);
    }
}
