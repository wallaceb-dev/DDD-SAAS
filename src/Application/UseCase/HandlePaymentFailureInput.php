<?php

namespace App\Application\UseCase;

use App\Domain\Subscription\ValueObjects\SubscriptionId;
use DateTimeImmutable;

class HandlePaymentFailureInput
{
    public function __construct(
        readonly SubscriptionId $subscriptionId,
        readonly DateTimeImmutable $failedAt,
    ) {
    }
}