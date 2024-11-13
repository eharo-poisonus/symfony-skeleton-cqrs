<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Create;

use App\Backoffice\Auth\Domain\Password;
use App\Backoffice\Auth\Domain\UserCredentials;
use App\Backoffice\Auth\Domain\UserCredentialsRepository;

final readonly class UserCredentialCreatorService
{
    public function __construct(
        private UserCredentialsRepository $userCredentialsRepository
    ) {
    }

    public function __invoke(string $user, Password $password): void
    {
        $this->userCredentialsRepository->create(
            new UserCredentials($user, $password)
        );
    }
}
