<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;

class UserCredentials extends AggregateRoot
{
    readonly private int $id;

    public function __construct(
        readonly private string $user,
        private readonly Password $password
    ) {
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
