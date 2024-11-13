<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

enum Auth: string
{
    case FREE = 'FREE';
    case JWT = 'JWT';
}
