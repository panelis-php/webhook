<?php

namespace Panelis\Webhook\Data;

use Panelis\Webhook\Enums\WebhookStatus;

final class WebhookData
{
    public function __construct(
        public readonly string $vendor,
        public readonly WebhookStatus $status,
        public readonly array $payload,
        public readonly array $metadata,
        public readonly ?string $event = null,
        public readonly ?string $exception = null,
    ) {}

}
