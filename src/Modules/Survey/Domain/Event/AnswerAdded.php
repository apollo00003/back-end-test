<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Event;

use App\Modules\Survey\Domain\Entity\Answer;
use App\SharedKernel\Domain\Bus\Event\AsyncEvent;

class AnswerAdded implements AsyncEvent
{
    public function __construct(protected Answer $answer)
    {
    }

    public function getAnswer(): Answer
    {
        return $this->answer;
    }
}