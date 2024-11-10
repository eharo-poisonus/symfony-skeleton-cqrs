<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Domain;

interface UserCredentialsRepository
{
    public function create(UserCredentials $userCredentials);

    public function getByUser(string $user): UserCredentials;

    public function getByUserAndPassword(string $user, string $password): UserCredentials;
}
