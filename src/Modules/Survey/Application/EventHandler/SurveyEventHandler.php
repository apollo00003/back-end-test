<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\EventHandler;

use App\Modules\Survey\Application\Service\ReportGenerator;
use App\Modules\Survey\Application\Service\ReportMailer;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Domain\Event\SurveyFinished;
use App\SharedKernel\Domain\Bus\Event\EventHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class SurveyEventHandler implements EventHandler
{
    public function __construct(
        private readonly ReportGenerator $reportGenerator,
        private readonly ReportMailer $reportMailer,
    ) {
    }

    #[AsMessageHandler]
    public function finishSurveyHandler(SurveyFinished $surveyFinished): Survey
    {
        $survey = $surveyFinished->getSurvey();
        $report = $this->reportGenerator->generate($survey);
        $this->reportMailer->send($report);

        return $survey;
    }
}