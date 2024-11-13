<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Domain\Events;

use App\Shared\Domain\Bus\Event\DomainEvent;

final readonly class EventWasCreated extends DomainEvent
{
    private const NAME = 'event.created';
    public function __construct(
        private string $test,
        string $aggregateId,
        string $eventId = null,
        string $occurredOn = null
    ) {

        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $body['test'],
            $aggregateId
        );
    }

    public function toPrimitives(): array
    {
        return [
            'test' => $this->test
        ];
    }

    public static function eventName(): string
    {
        return self::NAME;
    }
}
