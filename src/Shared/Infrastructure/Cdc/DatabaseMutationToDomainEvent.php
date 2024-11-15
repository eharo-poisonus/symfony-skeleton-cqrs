<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Cdc;

use App\Shared\Domain\Bus\Event\DomainEvent;

interface DatabaseMutationToDomainEvent
{
    /** @return DomainEvent[] */
    public function transform(array $data): array;

    public function tableName(): string;

    public function mutationAction(): DatabaseMutationAction;
}
