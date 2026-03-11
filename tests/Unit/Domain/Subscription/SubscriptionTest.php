<?php

use App\Domain\Subscription\Entities\Subscription;

it("activates a pending subscription", function () {
    $subscription = Subscription::create(
        id: "sub_123",
        customerId: "cus_123",
        planId: "plan_123",
    );

    $subscription->activate();

    expect($subscription->status()->value())->toBe("active");
});

it("cannot activate an active subscription", function () {
    $subscription = Subscription::create(
        id: "sub_123",
        customerId: "cus_123",
        planId: "plan_123",
    );

    $subscription->activate();

    $subscription->activate();

})->throws(DomainException::class, "Subscription is already active");