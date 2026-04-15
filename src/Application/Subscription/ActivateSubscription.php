<?php

use App\Domain\Subscription\Repositories\SubscriptionRepository;
use App\Domain\Subscription\ValueObjects\SubscriptionId;

class ActivateSubscription
{
    public function __construct(
        private SubscriptionRepository $repository
    ) {
    }


    public function execute(string $subscriptionId): void
    {
        $id = SubscriptionId::fromString($subscriptionId);

        $subscription = $this->repository->findById($id);

        if (!$subscription) {
            throw new \DomainException('Subscription not found');
        }

        $subscription->activate();

        $this->repository->save($subscription);
    }
}