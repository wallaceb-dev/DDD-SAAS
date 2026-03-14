<?php

namespace App\Domain\Subscription\Events;

class SubscriptionBecameDelinquent
{
    public function __construct(
        public readonly string $subscriptionId,
    ) {
    }
}