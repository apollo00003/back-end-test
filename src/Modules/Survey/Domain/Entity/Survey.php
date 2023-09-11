<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Entity;

use App\Modules\Survey\Domain\ValueObject\ReportId;
use App\Modules\Survey\Domain\ValueObject\SurveyId;
use Doctrine\Common\Collections\ArrayCollection; //intentional import
use Doctrine\Common\Collections\Collection; //intentional import

class Survey
{
    public const STATUS_NEW = 'new';
    public const STATUS_LIVE = 'live';
    public const STATUS_CLOSED = 'closed';

    private ?string $id = null;

    private ?string $name = null;

    private ?string $status = null;

    public Collection $answers;

    private ?string $reportId = null;

    private ?string $reportEmail = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function getReportId(): ?ReportId
    {
        if ($this->reportId) {
            return new ReportId($this->reportId);
        }

        return null;
    }

    public function setReport(ReportId $reportId): self
    {
        $this->reportId = $reportId->getValue();

        return $this;
    }

    public function getReportEmail(): string
    {
        return $this->reportEmail;
    }

    public function setReportEmail(string $reportEmail): self
    {
        $this->reportEmail = $reportEmail;

        return $this;
    }

    public static function create(string $name, string $reportEmail): self
    {
        return (new self())
            ->setStatus(self::STATUS_NEW)
            ->setName($name)
            ->setReportEmail($reportEmail);
    }

    public function addAnswer(string $comment, int $quality): Answer
    {
        $answer = (new Answer())
            ->setComment($comment)
            ->setQuality($quality);

        $this->answers->add($answer);

        return $answer;
    }
}
