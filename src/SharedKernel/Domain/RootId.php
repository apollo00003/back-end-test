<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

use InvalidArgumentException;

abstract class RootId
{
    protected string $uuid;

    public function __construct(string $uuid)
    {
        if (!preg_match('/^(?:\\{{0,1}(?:[0-9a-fA-F]){8}-(?:[0-9a-fA-F]){4}-(?:[0-9a-fA-F]){4}-(?:[0-9a-fA-F]){4}-(?:[0-9a-fA-F]){12}\\}{0,1})$/', $uuid)) {
            throw new InvalidArgumentException('Not valid UUID');
        }

        $this->uuid = $uuid;
    }

    public function getValue(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}