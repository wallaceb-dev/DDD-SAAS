<?php

namespace App\Domain\Subscription\Repositories;

use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\ValueObjects\SubscriptionId;

interface SubscriptionRepository
{
    public function save(Subscription $subscription): void;
    public function findById(SubscriptionId $id): ?Subscription;
}