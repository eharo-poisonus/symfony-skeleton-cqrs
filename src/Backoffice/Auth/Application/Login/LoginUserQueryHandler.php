<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Application\Login;

use App\Backoffice\Auth\Domain\Password;
use App\Shared\Domain\Bus\Query\QueryHandler;

readonly class LoginUserQueryHandler implements QueryHandler
{
    public function __construct(
        private UserLoginService $userLoginService
    ) {
    }

    public function __invoke(LoginUserQuery $loginUserQuery): LoginResponse
    {
        $password = new Password($loginUserQuery->password);

        return ($this->userLoginService)(
            $loginUserQuery->user,
            $password
        );
    }
}
