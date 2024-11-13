<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\Command;
use RuntimeException;

final class CommandNotRegistered extends RuntimeException
{
    public function __construct(Command $command)
    {
        $commandClass = $command::class;
        parent::__construct("The command <$commandClass> has no associated command handler");
    }
}
