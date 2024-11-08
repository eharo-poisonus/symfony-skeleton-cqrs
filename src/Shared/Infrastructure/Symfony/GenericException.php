<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use Exception;

abstract class GenericException extends Exception
{
    public function __construct(string $message = "", int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
