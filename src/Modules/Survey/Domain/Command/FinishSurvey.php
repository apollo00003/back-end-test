<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Command;

use App\Modules\Survey\Domain\ValueObject\SurveyId;
use App\SharedKernel\Domain\Bus\Command\Command;

class FinishSurvey implements Command
{
    public SurveyId $surveyId;

    public function __construct(SurveyId $surveyId = null)
    {
        $this->surveyId = $surveyId;
    }

    public function getSurveyId(): SurveyId
    {
        return $this->surveyId;
    }
}