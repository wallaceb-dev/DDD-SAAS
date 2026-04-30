<?php

namespace Tests\Support\EventBus;

use App\Application\Shared\EventBus;

class SimpleEventBus implements EventBus
{
    private array $handlers = [];

    public function register(string $eventClass, callable $handler): void
    {
        $this->handlers[$eventClass][] = $handler;
    }

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $eventClass = get_class($event);

            foreach ($this->handlers[$eventClass] ?? [] as $handler) {
                $handler($event);
            }
        }
    }
}