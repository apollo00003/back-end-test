<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Command;

use App\Modules\Survey\Domain\ValueObject\SurveyId;
use App\SharedKernel\Domain\Bus\Command\Command;

class EditSurvey implements Command
{
    public ?SurveyId $surveyId = null;

    public ?string $name = null;

    public ?string $reportEmail = null;

    public function __construct(SurveyId $surveyId = null, string $name = null, string $reportEmail = null)
    {
        $this->surveyId = $surveyId;
        $this->name = $name;
        $this->reportEmail = $reportEmail;
    }

    public function getSurveyId(): ?SurveyId
    {
        return $this->surveyId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getReportEmail(): ?string
    {
        return $this->name;
    }
}
