<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\FilterValueTypes;

use App\Shared\Domain\Criteria\FilterValue;

final readonly class IntegerFilterValue extends FilterValue
{
    public function __construct(
        private int $value
    ) {
    }

    public function value(): int
    {
        return $this->value;
    }
}
