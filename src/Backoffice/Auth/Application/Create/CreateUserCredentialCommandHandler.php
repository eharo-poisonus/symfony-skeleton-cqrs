<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Create;

use App\Backoffice\Auth\Domain\Password;
use App\Shared\Domain\Bus\Command\CommandHandler;

readonly class CreateUserCredentialCommandHandler implements CommandHandler
{
    public function __construct(
        private UserCredentialCreatorService $userCredentialCreatorService
    ) {
    }

    public function __invoke(CreateUserCredentialCommand $createUserCredentialCommand): void
    {
        $user = $createUserCredentialCommand->user;
        $password = new Password($createUserCredentialCommand->password);
        $this->userCredentialCreatorService->__invoke($user, $password);
    }
}
