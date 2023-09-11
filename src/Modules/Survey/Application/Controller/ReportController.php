<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Controller;

use App\Modules\Survey\Domain\Entity\Report;
use App\Modules\Survey\Domain\Repository\ReportRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/report', methods: 'GET')]
    public function index(ReportRepositoryInterface $reportRepository): JsonResponse
    {
        return $this->json($reportRepository->getAllReports());
    }

    #[Route('/report/{id}', methods: 'GET')]
    #[ParamConverter('report', Report::class)]
    public function show(Report $report): JsonResponse
    {
        return $this->json($report);
    }
}
