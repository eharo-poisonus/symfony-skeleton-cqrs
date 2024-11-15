<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class IntegerValueObject
{
    public function __construct(
        private readonly int $value
    ) {
    }

    public function value(): int
    {
        return $this->value;
    }
}