<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId\FindAnswerListByQuestionIdUseCase;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Question\FindQuestionById\FindQuestionByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexAnswerController extends AbstractController
{
    public function __construct(
        private readonly FindAnswerListByQuestionIdUseCase $findAnswerListByQuestionIdUseCase,
        private readonly FindQuestionByIdUseCase $findQuestionByIdUseCase
    ) {
    }

    #[Route(path: '/answer/{questionId}', name: 'answer.index', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $questionId */
        $questionId = $request->get('questionId', '');
        $input = new ByIdInputData($questionId);

        $output = $this->findAnswerListByQuestionIdUseCase->execute($input);
        $question = $this->findQuestionByIdUseCase->execute($input);

        return $this->render('answer/index.html.twig', [ 'records' => $output->answerList, 'question' => $question ]);
    }
}
