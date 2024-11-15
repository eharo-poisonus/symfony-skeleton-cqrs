<?php

namespace App\Shared\Domain\Criteria;

use App\Shared\Domain\Criteria\FilterValueTypes\ArrayFilterValue;
use App\Shared\Domain\Criteria\FilterValueTypes\BooleanFilterValue;
use App\Shared\Domain\Criteria\FilterValueTypes\FloatFilterValue;
use App\Shared\Domain\Criteria\FilterValueTypes\IntegerFilterValue;
use App\Shared\Domain\Criteria\FilterValueTypes\NullFilterValue;
use App\Shared\Domain\Criteria\FilterValueTypes\StringFilterValue;
use InvalidArgumentException;

abstract readonly class FilterValue
{
    public static function fromValue(mixed $value): static
    {
        return match (gettype($value)) {
            'string' => new StringFilterValue($value),
            'integer' => new IntegerFilterValue($value),
            'double' => new FloatFilterValue($value),
            'boolean' => new BooleanFilterValue($value),
            'NULL' => new NullFilterValue(),
            'array' => new ArrayFilterValue($value),
            default => throw new InvalidArgumentException("Invalid filter value type: $value")
        };
    }

    abstract public function value(): mixed;
}