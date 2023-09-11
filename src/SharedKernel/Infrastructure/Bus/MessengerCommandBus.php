<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Bus;

use App\SharedKernel\Domain\Bus\Command\AsyncCommand;
use App\SharedKernel\Domain\Bus\Command\Command;
use App\SharedKernel\Domain\Bus\Command\CommandBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {
    }

    public function dispatch(Command|AsyncCommand $command): void
    {
        $envelope = new Envelope($command);
        $this->commandBus->dispatch($envelope);
    }
}
