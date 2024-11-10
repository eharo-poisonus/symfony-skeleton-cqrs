<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Create;

use App\Shared\Domain\Bus\Command\Command;

readonly class CreateUserCredentialCommand implements Command
{
    public function __construct(
        public string $user,
        public string $password
    ) {
    }
}
