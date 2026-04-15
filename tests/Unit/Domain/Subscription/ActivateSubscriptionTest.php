<?php

use App\Application\Subscription\ActivateSubscription;
use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\ValueObjects\CustomerId;
use App\Domain\Subscription\ValueObjects\PlanId;
use App\Domain\Subscription\ValueObjects\SubscriptionId;
use Tests\Support\Repositories\InMemorySubscriptionRepository;

it('tests a subscription activation', function () {

    $subscription = Subscription::create(
        id: SubscriptionId::fromString('sub_1'),
        customerId: CustomerId::fromString('cus_1'),
        planId: PlanId::fromString('plan_1'),
    );

    $repository = new InMemorySubscriptionRepository();

    $repository->save($subscription);

    $useCase = new ActivateSubscription($repository);

    $useCase->execute('sub_1');

    $updated = $repository->findById(
        SubscriptionId::fromString('sub_1')
    );

    expect($updated->status()->value())->toBe('active');
});