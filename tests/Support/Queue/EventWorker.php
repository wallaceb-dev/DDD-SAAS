<?php

namespace Tests\Support\Queue;

class EventWorker
{
    public function __construct(
        private InMemoryQueue $queue,
        private array $handlers
    ) {}

    public function run(): void
    {
        while ($this->queue->hasJobs()) {
            $event = $this->queue->pull();

            $eventClass = get_class($event);

            foreach ($this->handlers[$eventClass] ?? [] as $handler) {
                $handler($event);
            }
        }
    }
}