<?php

namespace Tests\Support\EventBus;

use App\Application\Shared\EventBus;

class InMemoryEventBus implements EventBus
{
    public array $events = [];

    public function dispatch(array $events): void
    {
        $this->events = array_merge($this->events, $events);
    }
}