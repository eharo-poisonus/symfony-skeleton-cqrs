<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Login;

use App\Backoffice\Auth\Domain\Password;
use App\Backoffice\Auth\Domain\UserCredentialsRepository;
use DateTimeImmutable;
use Firebase\JWT\JWT;

final readonly class UserLoginService
{
    public function __construct(
        private UserCredentialsRepository $userCredentialsRepository
    ) {
    }

    public function __invoke(string $user, Password $password): LoginResponse
    {
        $userCredentials = $this->userCredentialsRepository->getByUser($user);
        $userCredentials->getPassword()->isEquals($password);

        $key = $_ENV['APP_SECRET'];
        $date = new DateTimeImmutable();
        $expire_at = $date->modify('+15 minutes')->getTimestamp();

        $payload = [
            'iat' => $date->getTimestamp(),
            'iss' => $_SERVER['SERVER_NAME'],
            'nbf' => $date->getTimestamp(),
            'exp' => $expire_at,
            'user' => $user,
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return new LoginResponse($jwt);
    }
}
