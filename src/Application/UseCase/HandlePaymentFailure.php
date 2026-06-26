<?php

namespace App\Application\UseCase;

use App\Application\Shared\EventBus;
use App\Domain\Subscription\Repositories\SubscriptionRepository;

class HandlePaymentFailure
{
    public function __construct(
        private SubscriptionRepository $repository,
        private EventBus $eventBus
    ) {}

    public function execute(HandlePaymentFailureInput $input): void
    {
        $subscription = $this->repository->findById($input->subscriptionId);
        
        if (!$subscription) {
            throw new \Exception("Subscription not found");
        }

        $subscription->handlePaymentFailure($input->failedAt);

        $this->repository->save($subscription);

        $events = $subscription->pullEvents();
        $this->eventBus->dispatch($events);
    }
}