<?php

use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\Events\SubscriptionActivated;
use App\Domain\Subscription\Events\SubscriptionBecameDelinquent;
use App\Domain\Subscription\Events\SubscriptionCanceled;

beforeEach(function () {
    $this->subscription = Subscription::create(
        id: "sub_123",
        customerId: "cus_123",
        planId: "plan_123",
    );
});

it("activates a pending subscription", function () {
    $this->subscription->activate();

    expect($this->subscription->status()->value())
        ->toBe("active");
});

it("cannot activate an active subscription", function () {
    $this->subscription->activate();
    $this->subscription->activate();
})->throws(DomainException::class);

it("it cancels an active subscription", function () {
    $this->subscription->activate();
    $this->subscription->cancel();

    expect($this->subscription->status()->value())
        ->toBe("canceled");
});

it("cancels a delinquent subscription", function () {
    $this->subscription->activate();
    $this->subscription->markDelinquent();
    $this->subscription->cancel();

    expect($this->subscription->status()->value())
        ->toBe("canceled");
});

it("cannot cancel an already canceled subscription", function () {
    $this->subscription->activate();
    $this->subscription->cancel();
    $this->subscription->cancel();
})->throws(DomainException::class);

it("cannot mark a canceled subscription as delinquent", function () {
    $this->subscription->activate();
    $this->subscription->cancel();
    $this->subscription->markDelinquent();
})->throws(DomainException::class);

it("records an event when a subscription is activated", function () {
    $this->subscription->activate();
    
    $events = $this->subscription->pullEvents();

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(SubscriptionActivated::class);
});

it("records an event when a subscription is canceled", function () {
    $this->subscription->cancel();
    
    $events = $this->subscription->pullEvents();

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(SubscriptionCanceled::class);
});

it("records an event when a subscription is marked as delinquent", function () {
    $this->subscription->activate();
    $this->subscription->markDelinquent();
    
    $events = $this->subscription->pullEvents();

    expect($events)->toHaveCount(2);
    expect($events[1])->toBeInstanceOf(SubscriptionBecameDelinquent::class);
});