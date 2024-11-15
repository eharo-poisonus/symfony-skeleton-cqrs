<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\FilterValueTypes;

use App\Shared\Domain\Criteria\FilterValue;

final readonly class FloatFilterValue extends FilterValue
{
    public function __construct(
        private float $value
    ) {
    }

    public function value(): float
    {
        return $this->value;
    }
}
