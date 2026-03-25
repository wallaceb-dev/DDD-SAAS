<?php

use App\Domain\Subscription\ValueObjects\CustomerId;

it('creates a customer id', function () {
    $id = CustomerId::fromString('cus_1');

    expect($id->value())->toBe('cus_1');
});