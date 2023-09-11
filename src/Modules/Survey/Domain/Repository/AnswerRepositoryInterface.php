<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Repository;

use App\Modules\Survey\Domain\Entity\Answer;

interface AnswerRepositoryInterface
{
    public function save(Answer $answer): void;

    public function remove(Answer $answer): void;
}