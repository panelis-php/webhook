<?php

namespace Panelis\Webhook\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Panelis\Webhook\Providers\WebhookServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [ActivitylogServiceProvider::class, WebhookServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
        $app['config']->set('activitylog.enabled', true);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('webhooks', function (Blueprint $table): void {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('vendor');
            $table->string('event')->nullable();
            $table->string('status');
            $table->json('payload');
            $table->json('metadata')->nullable();
            $table->text('exception')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_log', function (Blueprint $table): void {
            $table->id();
            $table->string('log_name')->nullable()->index();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->string('event')->nullable();
            $table->nullableMorphs('causer', 'causer');
            $table->json('attribute_changes')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }
}
