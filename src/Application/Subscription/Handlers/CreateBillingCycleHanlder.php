<?php

namespace App\Application\Subscription\Handlers;

use App\Domain\Subscription\Events\SubscriptionActivated;

class CreateBillingCycleHanlder
{
    public function handle(SubscriptionActivated $event): void
    {
        echo "Creating a billing cycle for {$event->subscriptionId}\n";
    }
}