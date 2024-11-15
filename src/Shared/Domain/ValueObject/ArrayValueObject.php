<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

class ArrayValueObject
{
    public function __construct(
        private readonly array $value
    ) {
    }

    public function value(): array
    {
        return $this->value;
    }
}
