<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Application\Event\Create;

use App\Backoffice\Auth\Application\Create\CreateUserCredentialCommand;
use App\Backoffice\Events\Domain\Events\EventWasCreated;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Event\InMemoryDomainEventSubscriber;

class EventMemoryOnEventWasCreatedHandler implements InMemoryDomainEventSubscriber
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(EventWasCreated $event): void
    {
        $this->commandBus->dispatch(new CreateUserCredentialCommand('memory', 'memory'));
    }

    public static function subscribedTo(): array
    {
        return [EventWasCreated::class];
    }
}
