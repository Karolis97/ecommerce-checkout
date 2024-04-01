<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    use EnumToArray;

    case PENDING    = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED    = 'shipped';
    case DELIVERED  = 'delivered';
    case CANCELED   = 'canceled';
}
