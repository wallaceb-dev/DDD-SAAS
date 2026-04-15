<?php

use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\Repositories\SubscriptionRepository;
use App\Domain\Subscription\ValueObjects\SubscriptionId;

class InMemorySubscriptionRepository implements SubscriptionRepository
{
    private array $items = [];


    public function save(Subscription $subscription): void
    {
        $this->items[$subscription->id()->value()] = $subscription;
    }
    
    public function findById(SubscriptionId $id): ?Subscription
    {
        return $this->items[$id->value()] ?? null;
    }
}