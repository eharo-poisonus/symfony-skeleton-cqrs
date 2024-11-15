<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class FloatValueObject
{
    public function __construct(
        private readonly float $value
    ) {
    }

    public function value(): float
    {
        return $this->value;
    }
}
