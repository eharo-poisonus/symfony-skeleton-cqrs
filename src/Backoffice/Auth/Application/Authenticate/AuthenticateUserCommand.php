<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Authenticate;

use App\Shared\Domain\Bus\Command\Command;

readonly class AuthenticateUserCommand implements Command
{
    public function __construct(
        public string $token
    ) {
    }
}
