<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Repository;

use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Domain\ValueObject\SurveyId;

interface SurveyRepositoryInterface
{
    /**
     * @return Survey[]
     */
    public function getAllSurveys(): array;

    public function findById(SurveyId $surveyId): ?Survey;

    public function save(Survey $survey): void;

    public function remove(Survey $survey): void;
}