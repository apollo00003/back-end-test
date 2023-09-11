<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Command;

use App\SharedKernel\Domain\Bus\Command\Command;

class CreateSurvey implements Command
{
    public ?string $name = null;

    public ?string $reportEmail = null;

    public function __construct(string $name = null, string $reportEmail = null)
    {
        $this->name = $name;
        $this->reportEmail = $reportEmail;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getReportEmail(): ?string
    {
        return $this->reportEmail;
    }
}