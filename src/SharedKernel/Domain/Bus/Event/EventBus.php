<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Bus\Event;

interface EventBus
{
    public function dispatch(Event|AsyncEvent $event): void;
}
