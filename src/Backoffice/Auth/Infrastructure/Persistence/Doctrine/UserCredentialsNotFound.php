<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Infrastructure\Persistence\Doctrine;

use App\Shared\Infrastructure\Symfony\GenericException;
use Symfony\Component\HttpFoundation\Response;

class UserCredentialsNotFound extends GenericException
{
    public function __construct()
    {
        parent::__construct('The user or password are incorrect', Response::HTTP_UNAUTHORIZED);
    }
}
