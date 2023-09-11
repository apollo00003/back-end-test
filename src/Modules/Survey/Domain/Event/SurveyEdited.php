<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Event;

use App\Modules\Survey\Domain\Entity\Survey;
use App\SharedKernel\Domain\Bus\Event\AsyncEvent;

class SurveyEdited implements AsyncEvent
{
    public function __construct(protected Survey $survey)
    {
    }

    public function getSurvey(): Survey
    {
        return $this->survey;
    }
}