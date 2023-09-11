<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Entity;

use App\Modules\Survey\Domain\ValueObject\ReportId;
use App\Modules\Survey\Domain\ValueObject\SurveyId;
use DateTimeImmutable;

class Report
{
    private ?string $id = null;

    private ?int $numberOfAnswers = null;

    private ?int $quality = null;

    private array $comments = [];

    private ?DateTimeImmutable $generatedAt = null;

    private ?string $surveyId = null;

    public function getId(): ?ReportId
    {
        return new ReportId($this->id);
    }

    public function setId(?ReportId $id): self
    {
        $this->id = $id->getValue();

        return $this;
    }

    public function getNumberOfAnswers(): ?int
    {
        return $this->numberOfAnswers;
    }

    public function setNumberOfAnswers(int $numberOfAnswers): self
    {
        $this->numberOfAnswers = $numberOfAnswers;

        return $this;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getGeneratedAt(): ?DateTimeImmutable
    {
        return $this->generatedAt;
    }

    public function setGeneratedAt(DateTimeImmutable $generatedAt): self
    {
        $this->generatedAt = $generatedAt;

        return $this;
    }

    public function getSurveyId(): ?SurveyId
    {
        return new SurveyId($this->surveyId);
    }

    public function setSurveyId(?SurveyId $surveyId): self
    {
        $this->surveyId = $surveyId->getValue();

        return $this;
    }
}
