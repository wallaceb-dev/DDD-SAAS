<?php

use App\Application\Subscription\ActivateSubscription;
use App\Application\Subscription\Handlers\CreateBillingCycleHanlder;
use App\Application\Subscription\Handlers\SendWelcomeEmailHandler;
use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\Events\SubscriptionActivated;
use App\Domain\Subscription\ValueObjects\CustomerId;
use App\Domain\Subscription\ValueObjects\PlanId;
use App\Domain\Subscription\ValueObjects\SubscriptionId;
use Tests\Support\EventBus\InMemoryEventBus;
use Tests\Support\EventBus\SimpleEventBus;
use Tests\Support\Repositories\InMemorySubscriptionRepository;

it('dispatches event when subscription is activated', function () {

    $repository = new InMemorySubscriptionRepository();
    $eventBus = new InMemoryEventBus();

    $subscription = Subscription::create(
        id: SubscriptionId::fromString('sub_1'),
        customerId: CustomerId::fromString('cus_1'),
        planId: PlanId::fromString('plan_1'),
    );

    $repository->save($subscription);

    $useCase = new ActivateSubscription($repository, $eventBus);

    $useCase->execute('sub_1');

    expect($eventBus->events)->toHaveCount(1);
    expect($eventBus->events[0])->toBeInstanceOf(SubscriptionActivated::class);
});

it('calls handlers when subscription is activated', function () {

    $repository = new InMemorySubscriptionRepository();
    $eventBus = new SimpleEventBus();

    $handlerSendWelcomeEmail = new SendWelcomeEmailHandler();
    $handlerCreateBillingCyle = new CreateBillingCycleHanlder();

    $eventBus->register(SubscriptionActivated::class, [$handlerSendWelcomeEmail, 'handle']);
    $eventBus->register(SubscriptionActivated::class, [$handlerCreateBillingCyle, 'handle']);

    $subscription = Subscription::create(
        id: SubscriptionId::fromString('sub_1'),
        customerId: CustomerId::fromString('cus_1'),
        planId: PlanId::fromString('plan_1'),
    );

    $repository->save($subscription);

    $useCase = new ActivateSubscription($repository, $eventBus);

    ob_start();

    $useCase->execute('sub_1');

    $output = ob_get_clean();

    expect($output)->toContain('Sending welcome email');
    expect($output)->toContain('Creating a billing cycle');
});