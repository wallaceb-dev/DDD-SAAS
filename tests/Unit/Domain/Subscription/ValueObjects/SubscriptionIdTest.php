<?php

use App\Domain\Subscription\ValueObjects\SubscriptionId;

it('creates a subscription id', function () {
    $id = SubscriptionId::fromString('sub_1');

    expect($id->value())->toBe('sub_1');
});