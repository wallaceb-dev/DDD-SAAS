<?php

use App\Domain\Subscription\ValueObjects\PlanId;

it('creates a plan id', function () {
    $planId = PlanId::fromString('plan_1');

    expect($plaId->value())->toBe('plan_1');
});