<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Bus\Query;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
