<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\FilterValueTypes;

use App\Shared\Domain\Criteria\FilterValue;

final readonly class BooleanFilterValue extends FilterValue
{
    public function __construct(
        private bool $value
    ) {
    }

    public function value(): bool
    {
        return $this->value;
    }
}
