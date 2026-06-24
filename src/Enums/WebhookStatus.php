<?php

namespace Panelis\Webhook\Enums;

enum WebhookStatus: string
{
    case Pending = 'pending';

    case Success = 'success';

    case Failed = 'failed';
}
