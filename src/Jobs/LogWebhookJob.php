<?php

namespace Panelis\Webhook\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Panelis\Webhook\Data\WebhookData;
use Panelis\Webhook\Models\Webhook;

use function Illuminate\Support\now;

class LogWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public WebhookData $data) {}

    public function handle(): void
    {
        Webhook::create([
            'ulid' => (string) Str::ulid(),
            'vendor' => $this->data->vendor,
            'event' => $this->data->event,
            'status' => $this->data->status,
            'payload' => $this->data->payload,
            'metadata' => $this->data->metadata,
            'exception' => $this->data->exception,
            'processed_at' => now(),
        ]);
    }
}
