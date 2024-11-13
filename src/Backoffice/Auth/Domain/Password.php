<?php

declare(strict_types=1);

namespace App\Backoffice\Auth\Domain;

class Password
{
    public function __construct(private string $value)
    {
        $this->encrypt();
    }

    private function encrypt(): void
    {
        $this->value = password_hash($this->value, PASSWORD_BCRYPT);
    }

    public function isEquals(Password $other): bool
    {
        return $this->value() === $other->value();
    }

    private function value(): string
    {
        return $this->value;
    }
}
