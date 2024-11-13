<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Application\Command\Create;

use App\Shared\Domain\Bus\Command\CommandHandler;

class CreateEventCommandHandler implements CommandHandler
{
    public function __construct(
        private EventCreatorService $eventCreator
    ) {
    }

    public function __invoke(CreateEventCommand $command): void
    {
        ($this->eventCreator)(test: $command->test());
    }
}
