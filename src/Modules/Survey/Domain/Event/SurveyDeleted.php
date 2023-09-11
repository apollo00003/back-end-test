<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Event;

use App\Modules\Survey\Domain\ValueObject\SurveyId;
use App\SharedKernel\Domain\Bus\Event\AsyncEvent;

class SurveyDeleted implements AsyncEvent
{
    public function __construct(protected SurveyId $surveyId)
    {
    }

    public function getSurveyId(): SurveyId
    {
        return $this->surveyId;
    }
}