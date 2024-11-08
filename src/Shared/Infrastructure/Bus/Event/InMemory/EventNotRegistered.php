<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event\InMemory;

use App\Shared\Domain\Bus\Event\DomainEvent;
use RuntimeException;

final class EventNotRegistered extends RuntimeException
{
    public function __construct(string $eventName)
    {
        parent::__construct("The domain event class for <$eventName> does not exist or have no subscribers.");
    }
}
