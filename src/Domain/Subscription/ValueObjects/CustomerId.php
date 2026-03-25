<?php

namespace App\Domain\Subscription\ValueObjects;

use InvalidArgumentException;

class CustomerId
{
    private function __construct(
        private string $value
    ) {
    }

    public static function fromString(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('CustomerId cannot be empty');
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}