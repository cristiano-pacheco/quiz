<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Question\FindQuestionListByQuizId\FindQuestionListByQuizIdUseCase;
use App\Code\Application\UseCase\Quiz\FindQuizById\FindQuizByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexQuestionController extends AbstractController
{
    public function __construct(
        private readonly FindQuestionListByQuizIdUseCase $findQuestionListByQuizIdUseCase,
        private readonly FindQuizByIdUseCase $findQuizByIdUseCase
    ) {
    }

    #[Route(path: '/question/{quizId}', name: 'question.index', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $quizId */
        $quizId = $request->get('quizId', '');
        $input = new ByIdInputData($quizId);

        $output = $this->findQuestionListByQuizIdUseCase->execute($input);
        $quiz = $this->findQuizByIdUseCase->execute($input);

        return $this->render('question/index.html.twig', [ 'records' => $output->questionList, 'quiz' => $quiz ]);
    }
}
