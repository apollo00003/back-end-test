<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Command;

use App\Modules\Survey\Domain\ValueObject\SurveyId;
use App\SharedKernel\Domain\Bus\Command\Command;

class AddAnswer implements Command
{
    public ?string $comment = null;

    public ?int $quality = null;

    public ?SurveyId $surveyId = null;

    public function __construct(string $comment = null, string $quality = null, SurveyId $surveyId = null)
    {
        $this->comment = $comment;
        $this->quality = $quality;
        $this->surveyId = $surveyId;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function getSurveyId(): SurveyId
    {
        return $this->surveyId;
    }
}