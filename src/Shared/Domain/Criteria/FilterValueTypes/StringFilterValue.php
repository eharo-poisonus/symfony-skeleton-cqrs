<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\FilterValueTypes;

use App\Shared\Domain\Criteria\FilterValue;

final readonly class StringFilterValue extends FilterValue
{
    public function __construct(
        private string $value
    ) {
    }


    public function value(): string
    {
        return $this->value;
    }
}
