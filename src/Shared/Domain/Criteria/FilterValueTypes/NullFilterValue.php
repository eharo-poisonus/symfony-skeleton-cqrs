<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\FilterValueTypes;

use App\Shared\Domain\Criteria\FilterValue;

final readonly class NullFilterValue extends FilterValue
{
    public function value(): null
    {
        return null;
    }
}
