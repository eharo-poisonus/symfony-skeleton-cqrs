<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Application\Event\Create;

use App\Backoffice\Auth\Application\Create\CreateUserCredentialCommand;
use App\Backoffice\Events\Domain\Events\EventWasCreated;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Event\RabbitMqDomainEventSubscriber;

final readonly class EventProjectionOnEventWasCreatedHandler implements RabbitMqDomainEventSubscriber
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(EventWasCreated $event): void
    {
        $this->commandBus->dispatch(new CreateUserCredentialCommand($event->toPrimitives()['test'], '12341234'));
    }

    public static function subscribedTo(): array
    {
        return [
            EventWasCreated::class
        ];
    }
}
