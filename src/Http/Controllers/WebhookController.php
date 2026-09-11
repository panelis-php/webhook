<?php

declare(strict_types=1);

namespace Panelis\Webhook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use InvalidArgumentException;
use Panelis\Webhook\Contracts\Webhook;
use Panelis\Webhook\Data\WebhookData;
use Panelis\Webhook\Enums\WebhookStatus;
use Panelis\Webhook\Jobs\LogWebhookJob;
use Throwable;

class WebhookController extends Controller
{
    public function __invoke(Request $request, string $vendor): mixed
    {
        $config = config(sprintf('webhook.vendors.%s', $vendor));
        abort_unless(filled($config), 404);

        $handler = $config['handler'];
        abort_unless(filled($handler), 500, 'Missing handler for vendor');

        $instance = app($handler);

        if (! $instance instanceof Webhook) {
            throw new InvalidArgumentException(
                sprintf('%s must implement %s', $handler, Webhook::class),
            );
        }

        $response = null;
        $exception = null;

        try {
            $instance->validate($request);

            $response = $instance->handle($request);
        } catch (Throwable $e) {
            $exception = $e;

            throw $e;
        } finally {
            if ($config['store'] ?? false) {
                LogWebhookJob::dispatch(new WebhookData(
                    vendor: $vendor,
                    status: $exception ? WebhookStatus::Failed : WebhookStatus::Success,
                    exception: $exception?->getMessage(),
                    payload: $request->all(),
                    metadata: [],
                ));
            }
        }

        return $response;
    }
}
