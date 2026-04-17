<?php

use App\Application\Subscription\CancelSubscription;
use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\ValueObjects\CustomerId;
use App\Domain\Subscription\ValueObjects\PlanId;
use App\Domain\Subscription\ValueObjects\SubscriptionId;
use Tests\Support\Repositories\InMemorySubscriptionRepository;

it('cancels a subscription via application service', function () {

    $subscription = Subscription::create(
        id: SubscriptionId::fromString('sub_1'),
        customerId: CustomerId::fromString('cus_1'),
        planId: PlanId::fromString('plan_1'),
    );

    $repository = new InMemorySubscriptionRepository();

    $repository->save($subscription);

    $useCase = new CancelSubscription($repository);

    $useCase->execute('sub_1');

    $updated = $repository->findById(
        SubscriptionId::fromString('sub_1')
    );

    expect($updated->status()->value())->toBe('canceled');
});