<?php

namespace App\Application\Subscription\Handlers;

use App\Domain\Subscription\Events\SubscriptionActivated;

class SendWelcomeEmailHandler
{
    public function handle(SubscriptionActivated $event): void
    {
        echo "Sending welcome email for {$event->subscriptionId}\n";
    }
}