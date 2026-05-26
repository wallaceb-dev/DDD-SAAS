<?php

namespace Tests\Support\Queue;

class InMemoryQueue
{
    private array $jobs = [];

    public function push(object $event): void
    {
        $this->jobs[] = $event;
    }

    public function pull(): ?object
    {
        return array_shift($this->jobs);
    }

    public function hasJobs(): bool
    {
        return !empty($this->jobs);
    }
}