<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Application\Command\Create;

use App\Backoffice\Events\Domain\Events;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\SimpleUuid;

final readonly class EventCreatorService
{
    public function __construct(
        private EventBus $asyncBus
    ) {
    }

    public function __invoke(string $test): void
    {
        $events = new Events(SimpleUuid::random()->value(), $test);
        $events->create($events->uuid(), $events->test());

        $this->asyncBus->publish(...$events->pullDomainEvents());
    }
}
