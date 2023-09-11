<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\CommandHandler;

use App\Modules\Survey\Domain\Command\AddAnswer;
use App\Modules\Survey\Domain\Entity\Answer;
use App\Modules\Survey\Domain\Event\AnswerAdded;
use App\Modules\Survey\Domain\Repository\AnswerRepositoryInterface;
use App\Modules\Survey\Domain\Repository\SurveyRepositoryInterface;
use App\SharedKernel\Domain\Bus\Command\CommandHandler;
use App\SharedKernel\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class AnswerCommandHandler implements CommandHandler
{
    public function __construct(
        protected SurveyRepositoryInterface $surveyRepository,
        protected AnswerRepositoryInterface $answerRepository,
        protected EventBus $eventBus
    ) {
    }

    #[AsMessageHandler]
    public function addAnswerHandler(AddAnswer $addAnswer): Answer
    {
        $survey = $this->surveyRepository->findById($addAnswer->getSurveyId());
        $answer = $survey->addAnswer($addAnswer->getComment(), $addAnswer->getQuality());
        $this->surveyRepository->save($survey);
        $this->eventBus->dispatch(new AnswerAdded($answer));

        return $answer;
    }
}