<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\FilterValueTypes;

use App\Shared\Domain\Criteria\FilterValue;

final readonly class ArrayFilterValue extends FilterValue
{
    public function __construct(
        private array $value
    ) {
    }

    public function value(): array
    {
        return $this->value;
    }
}
