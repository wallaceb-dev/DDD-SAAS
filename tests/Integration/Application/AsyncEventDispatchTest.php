<?php

use App\Application\Subscription\ActivateSubscription;
use App\Application\Subscription\Handlers\SendWelcomeEmailHandler;
use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\Events\SubscriptionActivated;
use App\Domain\Subscription\ValueObjects\CustomerId;
use App\Domain\Subscription\ValueObjects\PlanId;
use App\Domain\Subscription\ValueObjects\SubscriptionId;
use Tests\Support\EventBus\AsyncEventBus;
use Tests\Support\Queue\EventWorker;
use Tests\Support\Queue\InMemoryQueue;
use Tests\Support\Repositories\InMemorySubscriptionRepository;

it('processes events asynchronously', function () {

    $repository = new InMemorySubscriptionRepository();
    $queue = new InMemoryQueue();
    $eventBus = new AsyncEventBus($queue);

    $handler = new SendWelcomeEmailHandler();

    $handlers = [
        SubscriptionActivated::class => [
            [$handler, 'handle']
        ]
    ];

    $worker = new EventWorker($queue, $handlers);

    $subscription = Subscription::create(
        SubscriptionId::fromString('sub_1'),
        CustomerId::fromString('cust_1'),
        PlanId::fromString('plan_basic')
    );

    $repository->save($subscription);

    $useCase = new ActivateSubscription($repository, $eventBus);

    ob_start();

    $useCase->execute('sub_1');

    $outputBefore = ob_get_clean();

    expect($outputBefore)->toBeEmpty();

    ob_start();
    
    $worker->run();

    $outputAfter = ob_get_clean();

    expect($outputAfter)->toContain('Sending welcome email');

});