<?php

use App\Domain\Subscription\ValueObjects\PlanId;

it('creates a plan id', function () {
    $planId = PlanId::fromString('plan_1');

    expect($planId->value())->toBe('plan_1');
});