<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Infrastructure\Symfony\GenericException;

final class SubscriberNotRegistered extends GenericException
{
    public function __construct(string $subscriberName)
    {
        parent::__construct("The domain subscriber class for <$subscriberName> does not exist.");
    }
}
