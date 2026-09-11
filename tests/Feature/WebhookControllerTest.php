<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Panelis\Webhook\Contracts\Webhook;
use Panelis\Webhook\Http\Controllers\WebhookController;
use Panelis\Webhook\Jobs\LogWebhookJob;

class ThrowingWebhook implements Webhook
{
    public function validate(): void
    {
        throw new RuntimeException('webhook validation failed');
    }

    public function handle(): mixed
    {
        return null;
    }
}

it('stores an exception message when a webhook handler fails', function (): void {
    Queue::fake();
    config()->set('webhook.vendors.throwing', [
        'store' => true,
        'handler' => ThrowingWebhook::class,
    ]);

    $request = Request::create('/webhook/throwing', 'POST', [
        'event_type' => 'test',
    ]);

    expect(fn (): mixed => app(WebhookController::class)($request, 'throwing'))
        ->toThrow(RuntimeException::class, 'webhook validation failed');

    Queue::assertPushed(LogWebhookJob::class, function (LogWebhookJob $job): bool {
        return $job->data->exception === 'webhook validation failed';
    });
});
