<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Domain\Entity\Report;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Domain\Repository\ReportRepositoryInterface;
use App\Modules\Survey\Domain\ValueObject\SurveyId;

final class ReportGenerator
{
    public function __construct(private readonly ReportRepositoryInterface $reportRepository)
    {
    }

    public function generate(Survey $survey): Report
    {
        $answersCount = $survey->getAnswers()->count();

        if ($answersCount < 1) {
            $report = (new Report())
                ->setNumberOfAnswers($answersCount)
                ->setSurveyId(new SurveyId($survey->getId()))
                ->setGeneratedAt(new \DateTimeImmutable())
                ->setQuality(0)
                ->setComments([]);
        } else {
            $totalQuality = array_reduce($survey->getAnswers()->toArray(), fn($sum, $k) => $sum += $k->getQuality(), 0);
            $comments = $survey->getAnswers()->map(fn($x) => $x->getComment());
            $quality = (int)($totalQuality / $answersCount);
            $report = (new Report())
                ->setNumberOfAnswers($answersCount)
                ->setSurveyId(new SurveyId($survey->getId()))
                ->setGeneratedAt(new \DateTimeImmutable())
                ->setQuality($quality)
                ->setComments($comments->toArray());
        }

        $this->reportRepository->save($report);

        return $report;
    }
}
