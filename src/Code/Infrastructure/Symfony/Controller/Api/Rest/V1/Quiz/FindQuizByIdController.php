<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Api\Rest\V1\Quiz;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\FindQuizByIdEagerLoadUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FindQuizByIdController extends AbstractController
{
    public function __construct(private readonly FindQuizByIdEagerLoadUseCase $findQuizByIdEagerLoadUseCase)
    {
    }

    /**
     * @throws CouldNotFindAnswerException
     * @throws CouldNotFindQuestionException
     * @throws CouldNotFindQuizException
     */
    #[Route(path: '/api/rest/v1/quizzes/{id}', name: 'api.rest.v1.quizzes', methods: [ 'GET' ])]
    public function __invoke(string $id): JsonResponse
    {
        $input = new ByIdInputData($id);
        $output = $this->findQuizByIdEagerLoadUseCase->execute($input);
        return $this->json($output);
    }
}
