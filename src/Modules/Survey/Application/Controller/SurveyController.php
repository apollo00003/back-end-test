<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Controller;

use App\Modules\Survey\Domain\Command\CreateSurvey;
use App\Modules\Survey\Domain\Command\DeleteSurvey;
use App\Modules\Survey\Domain\Command\EditSurvey;
use App\Modules\Survey\Domain\Command\FinishSurvey;
use App\Modules\Survey\Domain\Command\PublishSurvey;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Application\Form\SurveyType;
use App\Modules\Survey\Application\Security\Voter\SurveyVoter;
use App\Modules\Survey\Domain\Query\GetAllSurveys;
use App\Modules\Survey\Domain\ValueObject\SurveyId;
use App\SharedKernel\Domain\Bus\Query\QueryBus;
use App\SharedKernel\Infrastructure\Bus\MessengerCommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/survey')]
class SurveyController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly QueryBus $queryBus
    ) {
    }

    #[Route(methods: 'GET')]
    public function index(): JsonResponse
    {
        $payload = $this->queryBus->handle(new GetAllSurveys());

        return $this->json($payload);
    }

    #[Route(methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $createSurveyCommand = new CreateSurvey();
        $form = $this->createForm(SurveyType::class, $createSurveyCommand);
        $form->submit(json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($createSurveyCommand);
        } else {
            return $this->json($form);
        }

        return $this->json(data: null, status: Response::HTTP_ACCEPTED);
    }

    #[Route('/{id}', methods: 'PUT')]
    #[ParamConverter('survey', Survey::class)]
    public function edit(Survey $survey, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted(SurveyVoter::EDIT, $survey);

        $editSurveyCommand = new EditSurvey(new SurveyId($survey->getId()));
        $form = $this->createForm(SurveyType::class, $editSurveyCommand);
        $form->submit(json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($editSurveyCommand);
        } else {
            return $this->json($form);
        }

        return $this->json(data: null, status: Response::HTTP_ACCEPTED);
    }

    #[Route('/{id}', methods: 'DELETE')]
    #[ParamConverter('survey', Survey::class)]
    public function delete(Survey $survey): JsonResponse
    {
        $this->denyAccessUnlessGranted(SurveyVoter::DELETE, $survey);

        $deleteSurveyCommand = new DeleteSurvey(new SurveyId($survey->getId()));
        $this->commandBus->dispatch($deleteSurveyCommand);

        return $this->json(data: null, status: Response::HTTP_ACCEPTED);
    }

    #[Route('/{id}/publish', methods: 'POST')]
    #[ParamConverter('survey', Survey::class)]
    public function publish(Survey $survey): JsonResponse
    {
        $this->denyAccessUnlessGranted(SurveyVoter::PUBLISH, $survey);

        $publishSurveyCommand = new PublishSurvey(new SurveyId($survey->getId()));
        $this->commandBus->dispatch($publishSurveyCommand);

        return $this->json(data: null, status: Response::HTTP_ACCEPTED);
    }

    #[Route('/{id}/finish', methods: 'POST')]
    #[ParamConverter('survey', Survey::class)]
    public function finish(Survey $survey): JsonResponse
    {
        $this->denyAccessUnlessGranted(SurveyVoter::FINISH, $survey);

        $finishSurveyCommand = new FinishSurvey(new SurveyId($survey->getId()));
        $this->commandBus->dispatch($finishSurveyCommand);

        return $this->json(data: null, status: Response::HTTP_ACCEPTED);
    }
}
