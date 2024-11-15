<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class NullValueObject
{
    public function __construct(private readonly null $value)
    {
    }

    public function value(): null
    {
        return $this->value;
    }
}
