<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Repository;

use App\Modules\Survey\Domain\Entity\Report;

interface ReportRepositoryInterface
{
    /**
     * @return Report[]
     */
    public function getAllReports(): array;

    public function save(Report $report): void;

    public function remove(Report $report): void;
}