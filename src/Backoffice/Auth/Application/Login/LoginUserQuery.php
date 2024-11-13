<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Login;

use App\Shared\Domain\Bus\Query\Query;

readonly class LoginUserQuery implements Query
{
    public function __construct(
        public string $user,
        public string $password
    ) {
    }
}
