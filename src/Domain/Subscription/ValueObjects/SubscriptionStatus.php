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

    public function value(): string
    {
        return $this->value;
    }
}