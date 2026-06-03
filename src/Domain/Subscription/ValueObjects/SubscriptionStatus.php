<?php

namespace App\Domain\Subscription\ValueObjects;

class SubscriptionStatus
{
    private function __construct(
        private string $value
    ) {
    }

    public static function active(): self
    {
        return new self("active");
    }
    public static function pending(): self
    {
        return new self("pending");
    }
    public static function delinquent(): self
    {
        return new self("delinquent");
    }
    public static function canceled(): self
    {
        return new self("canceled");
    }

    // COMPORTAMENTO DE COMPARAÇÃO (Evita expor a string para ifs externos)
    public function equals(SubscriptionStatus $other): bool
    {
        return $this->value === $other->value;
    }

    public function isActive(): bool
    {
        return $this->value === 'active';
    }
    public function isPending(): bool
    {
        return $this->value === 'pending';
    }
    public function isDelinquent(): bool
    {
        return $this->value === 'delinquent';
    }
    public function isCanceled(): bool
    {
        return $this->value === 'canceled';
    }

    public function value(): string
    {
        return $this->value;
    }
}