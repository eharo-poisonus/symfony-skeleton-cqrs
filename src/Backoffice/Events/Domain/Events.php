<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Domain;

use App\Backoffice\Events\Domain\Events\EventWasCreated;
use App\Shared\Domain\Aggregate\AggregateRoot;

class Events extends AggregateRoot
{
    public function __construct(
        private string $uuid,
        private string $test
    ) {
    }

    public function create(string $uuid, string $test): void
    {
        $this->record(new EventWasCreated($test, $uuid));
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function test(): string
    {
        return $this->test;
    }

    public function setTest(string $test): void
    {
        $this->test = $test;
    }
}
