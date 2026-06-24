<?php

namespace Panelis\Webhook\Contracts;

interface Webhook
{
    public function validate(): void;

    public function handle(): mixed;
}
