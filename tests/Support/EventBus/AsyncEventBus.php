<?php

namespace Tests\Support\EventBus;

use App\Application\Shared\EventBus;
use Tests\Support\Queue\InMemoryQueue;

class AsyncEventBus implements EventBus
{
    public function __construct(
        private InMemoryQueue $queue
    ) {}

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->queue->push($event);
        }
    }
}