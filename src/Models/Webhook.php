<?php

namespace Panelis\Webhook\Models;

use Database\Factories\WebhookFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panelis\Webhook\Enums\WebhookStatus;

#[Fillable([
    'ulid',
    'vendor',
    'event',
    'status',
    'payload',
    'metadata',
    'exception',
    'processed_at',
])]
class Webhook extends Model
{
    /** @use HasFactory<WebhookFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'metadata' => 'array',
            'status' => WebhookStatus::class,
            'processed_at' => 'datetime',
        ];
    }
}
