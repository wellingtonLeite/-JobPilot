<?php

namespace App\Modules\Integrations\Contracts;

enum JobAvailability: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case UNKNOWN = 'unknown';
}
