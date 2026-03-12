<?php

namespace App\Domain\Subscription\Events;

class SubscriptionActivated
{
    public function __construct(
        public readonly string $subscriptionId,
    ) {
    }
}