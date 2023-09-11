<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\QueryHandler;

use App\Modules\Survey\Domain\Query\GetAllSurveys;
use App\Modules\Survey\Domain\Repository\SurveyRepositoryInterface;
use App\SharedKernel\Domain\Bus\Command\CommandHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllSurveysQueryHandler implements CommandHandler
{
    public function __construct(protected SurveyRepositoryInterface $surveyRepository)
    {
    }

    public function __invoke(GetAllSurveys $getAllSurveys): array
    {
        return $this->surveyRepository->getAllSurveys();
    }
}