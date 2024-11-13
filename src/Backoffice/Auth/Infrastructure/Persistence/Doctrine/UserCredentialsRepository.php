<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Infrastructure\Persistence\Doctrine;

use App\Backoffice\Auth\Domain\UserCredentials;
use App\Backoffice\Auth\Domain\UserCredentialsRepository as UserCredentialsRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Exception;

class UserCredentialsRepository extends DoctrineRepository implements UserCredentialsRepositoryInterface
{
    /** @throws Exception */
    public function create(UserCredentials $userCredentials): void
    {
        $this->persist($userCredentials);
    }

    /** @throws UserCredentialsNotFound */
    public function getByUserAndPassword(string $user, string $password): UserCredentials
    {
        $userCredentials = $this->repository(UserCredentials::class)->findOneBy(
            ['user' => $user, 'password' => $password]
        );
        $this->guardUserCredentialsExist($userCredentials);
        return $userCredentials;
    }


    /** @throws UserCredentialsNotFound */
    private function guardUserCredentialsExist(?UserCredentials $userCredentials)
    {
        if ($userCredentials === null) {
            throw new UserCredentialsNotFound();
        }
    }

    /** @throws UserCredentialsNotFound */
    public function getByUser(string $user): UserCredentials
    {
        $userCredentials = $this->repository(UserCredentials::class)
            ->findOneBy(
                ['user' => $user]
            );
        $this->guardUserCredentialsExist($userCredentials);
        return $userCredentials;
    }
}
