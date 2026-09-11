<?php

use Panelis\Webhook\Models\Webhook;
use Spatie\Activitylog\Models\Activity;

it('logs only safe webhook attributes', function (): void {
    $webhook = Webhook::create([
        'ulid' => (string) str()->ulid(),
        'vendor' => 'github',
        'event' => 'push',
        'status' => 'success',
        'payload' => ['token' => 'secret'],
        'metadata' => ['request_id' => 'abc'],
    ]);

    $activity = Activity::query()->firstOrFail();

    expect($activity->subject->is($webhook))->toBeTrue()
        ->and($activity->event)->toBe('created')
        ->and(data_get($activity->properties->toArray(), 'attributes.payload'))->toBeNull()
        ->and(data_get($activity->properties->toArray(), 'attributes.metadata'))->toBeNull();
});

it('does not log when activity logging is disabled', function (): void {
    config()->set('activitylog.enabled', false);

    Webhook::create([
        'ulid' => (string) str()->ulid(),
        'vendor' => 'github',
        'status' => 'success',
        'payload' => ['token' => 'secret'],
    ]);

    expect(Activity::query()->count())->toBe(0);
});
