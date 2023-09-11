<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Domain\Entity\Report;
use App\Modules\Survey\Domain\Repository\SurveyRepositoryInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class ReportMailer
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly SurveyRepositoryInterface $surveyRepository
    ) {
    }

    public function send(Report $report): void
    {
        $survey = $this->surveyRepository->findById($report->getSurveyId());
        $email = (new Email())
            ->from('hello@example.com')
            ->to($survey->getReportEmail())
            ->subject(sprintf('Report for survey "%s" is here!', $survey->getName()))
            ->text(
                sprintf(
                    'There should be a link to generated report but just id is also fine ;) - "%s"',
                    $report->getId(),
                ),
            );

        $this->mailer->send($email);
    }
}
