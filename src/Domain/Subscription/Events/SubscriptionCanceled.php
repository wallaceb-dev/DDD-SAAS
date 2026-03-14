<?php

namespace App\Domain\Subscription\Events;

class SubscriptionCanceled
{
    public function __construct(
        public readonly string $subscriptionId,
    ) {
    }
}