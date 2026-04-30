<?php

use App\Application\Subscription\CancelSubscription;
use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\Events\SubscriptionCanceled;
use App\Domain\Subscription\ValueObjects\CustomerId;
use App\Domain\Subscription\ValueObjects\PlanId;
use App\Domain\Subscription\ValueObjects\SubscriptionId;
use Tests\Support\EventBus\InMemoryEventBus;
use Tests\Support\Repositories\InMemorySubscriptionRepository;

it('dispatches event when subscription is canceled', function () {

    $repository = new InMemorySubscriptionRepository();
    $eventBus = new InMemoryEventBus();

    $subscription = Subscription::create(
        id: SubscriptionId::fromString('sub_1'),
        customerId: CustomerId::fromString('cus_1'),
        planId: PlanId::fromString('plan_1'),
    );


    $repository->save($subscription);

    $useCase = new CancelSubscription($repository, $eventBus);

    $useCase->execute('sub_1');

    expect($eventBus->events)->toHaveCount(1);
    expect($eventBus->events[0])->toBeInstanceOf(SubscriptionCanceled::class);
});