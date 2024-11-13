<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Authenticate;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\ValueObject\SimpleUuid;

readonly class AuthenticateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private UserAuthenticatorService $userAuthenticator
    ) {
    }

    public function __invoke(AuthenticateUserCommand $command): void
    {
        ($this->userAuthenticator)(
            $command->token
        );
    }
}
