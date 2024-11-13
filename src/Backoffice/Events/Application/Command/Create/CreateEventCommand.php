<?php

declare(strict_types=1);

namespace App\Backoffice\Events\Application\Command\Create;

use App\Shared\Domain\Bus\Command\Command;

class CreateEventCommand implements Command
{
    public function __construct(
        private string $test
    ) {
    }

    public function test(): string
    {
        return $this->test;
    }
}
