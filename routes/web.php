<?php

use Illuminate\Support\Facades\Route;
use Panelis\Webhook\Http\Controllers\WebhookController;

Route::post('/{vendor}', WebhookController::class);
