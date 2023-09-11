<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Controller;

use App\Modules\Survey\Domain\Command\AddAnswer;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Application\Form\AnswerType;
use App\Modules\Survey\Application\Security\Voter\SurveyVoter;
use App\Modules\Survey\Domain\ValueObject\SurveyId;
use App\SharedKernel\Domain\Bus\Command\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class AnswerController extends AbstractController
{
    #[Route('/survey/{id}/answer', methods: 'POST')]
    #[ParamConverter('survey', Survey::class)]
    public function create(Survey $survey, Request $request, CommandBus $commandBus): JsonResponse
    {
        $this->denyAccessUnlessGranted(SurveyVoter::ANSWER, $survey);

        $addAnswer = new AddAnswer(surveyId: new SurveyId($survey->getId()));
        $form = $this->createForm(AnswerType::class, $addAnswer);
        $form->submit(json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR));


        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->dispatch($addAnswer);
        } else {
            return $this->json($form);
        }

        return $this->json($survey);
    }
}
