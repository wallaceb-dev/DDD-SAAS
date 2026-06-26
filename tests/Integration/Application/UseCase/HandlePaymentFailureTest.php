<?php

use App\Application\UseCase\HandlePaymentFailure;
use App\Application\UseCase\HandlePaymentFailureInput;
use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\ValueObjects\SubscriptionId;
use App\Domain\Subscription\ValueObjects\CustomerId;
use App\Domain\Subscription\ValueObjects\PlanId;
use Tests\Support\EventBus\InMemoryEventBus;
use Tests\Support\Repositories\InMemorySubscriptionRepository;

it('should orchestrate payment failure workflow correctly', function () {

    $repository = new InMemorySubscriptionRepository();
    $eventBus = new InMemoryEventBus();
   
    $subscriptionId = SubscriptionId::fromString('sub_123');
    $subscription = Subscription::create(
        $subscriptionId,
        CustomerId::fromString('cus_1'),
        PlanId::fromString('plan_1')
    );
    $subscription->activate();
    
    $repository->save($subscription);

    $useCase = new HandlePaymentFailure($repository, $eventBus);
    
    $failedAt = new DateTimeImmutable('2026-06-25 10:00:00');
    $expectedGracePeriod = new DateTimeImmutable('2026-06-30 10:00:00');
    
    $input = new HandlePaymentFailureInput($subscriptionId, $failedAt);

    $useCase->execute($input);

    $updatedSubscription = $repository->findById($subscriptionId);
    
    expect($updatedSubscription)->not->toBeNull();
    expect($updatedSubscription->status()->isActive())->toBeTrue();
    expect($updatedSubscription->getGracePeriodUntil())->toEqual($expectedGracePeriod);
});