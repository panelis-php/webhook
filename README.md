# Panelis Webhook

A webhook manager for Laravel and Panelis applications.

## Features

* Register webhook vendors through configuration
* Generic webhook handlers
* Automatic route registration
* Optional webhook logging
* Queue-based logging
* Composer-based Panelis plugin discovery

## Requirements

* PHP 8.3+
* Laravel 13+
* Filament 5+

## Installation

Install the package via Composer:

```bash
composer require panelis-php/webhook
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=webhook-config
```

Publish the database migrations:

```bash
php artisan vendor:publish --tag=webhook-migrations
```

Run migrations:

```bash
php artisan migrate
```

## Configuration

Configure your webhook vendors in `config/webhook.php`:

```php
return [

    'prefix' => 'webhook',

    'vendors' => [

        'ping' => [
            'handler' => App\Webhook\PingWebhook::class,
        ],

    ],

];
```

This configuration automatically registers:

```text
POST /webhook/ping
```

## Creating a Handler

Create a webhook handler that implements the `Webhook` contract:

```php
<?php

namespace App\Webhook;

use Illuminate\Http\Request;
use Panelis\Webhook\Contracts\Webhook;

class PingWebhook implements Webhook
{
    public function validate(Request $request): void
    {
        //
    }

    public function handle(Request $request): mixed
    {
        return response()->json([
            'message' => 'pong',
        ]);
    }
}
```

## Logging

Webhook requests can be stored by enabling logging for a vendor:

```php
'vendors' => [

    'ping' => [
        'handler' => App\Webhook\PingWebhook::class,
        'store' => true,
    ],

],
```

Logged requests are stored in the `webhook_logs` table.

Available fields:

* ulid
* vendor
* event
* status
* payload
* metadata
* exception
* processed_at

## Example

Send a test request:

```bash
curl -X POST \
    http://localhost/webhook/ping \
    -H "Content-Type: application/json" \
    -d '{"hello":"world"}'
```

Response:

```json
{
    "message": "pong"
}
```

## Roadmap

* Filament Resource
* Webhook details page
* Retry failed webhooks
* Replay webhook payloads
* Dashboard widgets
* Failed webhook notifications

## License

The MIT License (MIT).
