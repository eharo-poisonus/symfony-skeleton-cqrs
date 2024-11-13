<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Login;

use App\Shared\Domain\Bus\Query\Response;

readonly class LoginResponse implements Response
{
    public function __construct(
        private string $token
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token
        ];
    }
}
