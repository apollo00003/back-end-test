<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\CommandHandler;

use App\Modules\Survey\Domain\Command\CreateSurvey;
use App\Modules\Survey\Domain\Command\DeleteSurvey;
use App\Modules\Survey\Domain\Command\EditSurvey;
use App\Modules\Survey\Domain\Command\FinishSurvey;
use App\Modules\Survey\Domain\Command\PublishSurvey;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Domain\Event\SurveyCreated;
use App\Modules\Survey\Domain\Event\SurveyDeleted;
use App\Modules\Survey\Domain\Event\SurveyEdited;
use App\Modules\Survey\Domain\Event\SurveyFinished;
use App\Modules\Survey\Domain\Event\SurveyPublished;
use App\Modules\Survey\Domain\Repository\SurveyRepositoryInterface;
use App\SharedKernel\Domain\Bus\Command\CommandHandler;
use App\SharedKernel\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class SurveyCommandHandler implements CommandHandler
{
    public function __construct(
        protected SurveyRepositoryInterface $surveyRepository,
        protected EventBus $eventBus
    ) {
    }

    #[AsMessageHandler]
    public function createSurveyHandler(CreateSurvey $createSurvey): Survey
    {
        $survey = Survey::create($createSurvey->getName(), $createSurvey->getReportEmail());
        $this->surveyRepository->save($survey);
        $this->eventBus->dispatch(new SurveyCreated($survey));

        return $survey;
    }

    #[AsMessageHandler]
    public function editSurveyHandler(EditSurvey $editSurvey): Survey
    {
        $survey = $this->surveyRepository->findById($editSurvey->getSurveyId());
        $survey->setName($editSurvey->getName());
        $survey->setReportEmail($editSurvey->getReportEmail());
        $this->surveyRepository->save($survey);
        $this->eventBus->dispatch(new SurveyEdited($survey));

        return $survey;
    }

    #[AsMessageHandler]
    public function deleteSurveyHandler(DeleteSurvey $deleteSurvey): Survey
    {
        $survey = $this->surveyRepository->findById($deleteSurvey->getSurveyId());
        $this->surveyRepository->remove($survey);
        $this->eventBus->dispatch(new SurveyDeleted($deleteSurvey->getSurveyId()));

        return $survey;
    }

    #[AsMessageHandler]
    public function publishSurveyHandler(PublishSurvey $publishSurvey): Survey
    {
        $survey = $this->surveyRepository->findById($publishSurvey->getSurveyId());
        $survey->setStatus($survey::STATUS_LIVE);
        $this->surveyRepository->save($survey);
        $this->eventBus->dispatch(new SurveyPublished($survey));

        return $survey;
    }

    #[AsMessageHandler]
    public function finishSurveyHandler(FinishSurvey $finishSurvey): Survey
    {
        $survey = $this->surveyRepository->findById($finishSurvey->getSurveyId());
        $survey->setStatus($survey::STATUS_CLOSED);
        $this->surveyRepository->save($survey);
        $this->eventBus->dispatch(new SurveyFinished($survey));

        return $survey;
    }
}