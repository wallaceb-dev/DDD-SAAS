<?php

use App\Domain\Subscription\ValueObjects\SubscriptionStatus;

it("crates an active status", function () {
    $status = SubscriptionStatus::active();

    expect($status->value())->toBe("active");
});

it("crates an pending status", function () {
    $status = SubscriptionStatus::pending();

    expect($status->value())->toBe("pending");
});

it("crates an delinquent status", function () {
    $status = SubscriptionStatus::delinquent();

    expect($status->value())->toBe("delinquent");
});
it("crates an canceled status", function () {
    $status = SubscriptionStatus::canceled();

    expect($status->value())->toBe("canceled");
});