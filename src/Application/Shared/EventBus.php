<?php

namespace App\Application\Shared;

interface EventBus
{
    public function dispatch(array $events): void;
}