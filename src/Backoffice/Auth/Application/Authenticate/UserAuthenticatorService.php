<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Authenticate;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final readonly class UserAuthenticatorService
{
    public function __invoke(string $token): void
    {
        $decodedToken = JWT::decode($token, new Key($_ENV['SECRET_KEY'], 'HS256'));
    }
}
