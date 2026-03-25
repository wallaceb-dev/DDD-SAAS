<?php

use App\Domain\Subscription\ValueObjects\CustomerId;

it('creates a customer id', function () {
    $CustomerId = CustomerId::fromString('cus_1');

    expect($CustomerId->value())->toBe('cus_1');
});