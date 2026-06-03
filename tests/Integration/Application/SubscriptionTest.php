<?php

use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\ValueObjects\CustomerId;
use App\Domain\Subscription\ValueObjects\PlanId;
use App\Domain\Subscription\ValueObjects\SubscriptionId;

beforeEach(function () {
    $this->subscription = Subscription::create(
        id: SubscriptionId::fromString('sub_1'),
        customerId: CustomerId::fromString('cus_1'),
        planId: PlanId::fromString('plan_1'),
    );
});


it('should enter grace period on payment failure but keep status active', function () {
    $this->subscription = Subscription::create(
        id: SubscriptionId::fromString('sub_1'),
        customerId: CustomerId::fromString('cus_1'),
        planId: PlanId::fromString('plan_1'),
    );

    $this->subscription->activate();

    $failedAt = new DateTimeImmutable('2026-06-03 10:00:00');
    $expectedGracePeriodUntil = new DateTimeImmutable('2026-06-08 10:00:00');

    $this->subscription->handlePaymentFailure($failedAt);

    expect($this->subscription->status()->isActive())->toBeTrue();
    expect($this->subscription->getGracePeriodUntil())->toEqual($expectedGracePeriodUntil);
});

it('should throw exception when handling payment failure on non active subscription', function () {
    $failedAt = new DateTimeImmutable('2026-06-03 10:00:00');

    expect(fn() => $this->subscription->handlePaymentFailure($failedAt))
        ->toThrow(DomainException::class, "Subscription must be active to handle payment failure");
});