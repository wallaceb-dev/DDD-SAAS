<?php

namespace App\Domain\Subscription\ValueObjects;

use InvalidArgumentException;

class SubscriptionId
{
    private function __construct(
        private string $value
    ) {
    }

    public static function fromString(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('SubscriptionId cannot be empty');
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}