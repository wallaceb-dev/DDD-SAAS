<?php

namespace App\Domain\Subscription\Entities;

use App\Domain\Subscription\Events\SubscriptionActivated;
use App\Domain\Subscription\ValueObjects\SubscriptionStatus;
use DomainException;

class Subscription
{
    private function __construct(
        private string $id,
        private string $customerId,
        private string $planId,
        private SubscriptionStatus $status,
        private array $domainEvents = []
    ) {
    }

    public static function create(
        string $id,
        string $customerId,
        string $planId
    ): self {
        return new self(
            id: $id,
            customerId: $customerId,
            planId: $planId,
            status: SubscriptionStatus::pending()
        );
    }

    public function status(): SubscriptionStatus
    {
        return $this->status;
    }

    public function activate(): void
    {
        if ($this->status->value() !== 'pending') {
            throw new DomainException("Subscription is already active");
        }

        $this->status = SubscriptionStatus::active();

        $this->recordEvent(
            new SubscriptionActivated($this->id)
        );
    }

    public function cancel(): void
    {
        if ($this->status->value() === "canceled") {
            throw new DomainException("Subscription already canceled");
        }

        $this->status = SubscriptionStatus::canceled();
    }

    public function markDelinquent(): void
    {
        if ($this->status->value() !== "active") {
            throw new DomainException("Only active subscription can become delinquent");
        }

        $this->status = SubscriptionStatus::delinquent();
    }

    private function recordEvent(object $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function pullEvents(): array
    {
        $events = $this->domainEvents;

        $this->domainEvents = [];

        return $events;
    }
}