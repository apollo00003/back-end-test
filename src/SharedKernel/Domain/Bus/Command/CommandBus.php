<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command|AsyncCommand $command): void;
}
