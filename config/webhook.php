<?php

use Panelis\Webhook\Webhooks\PingWebhook;

return [
    'prefix' => 'webhook',

    'vendors' => [
        'ping' => [
            'store' => false,
            'handler' => PingWebhook::class,
        ],
    ],
];
