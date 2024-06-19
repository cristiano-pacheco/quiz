<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Question\FindQuestionById\FindQuestionByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditQuestionController extends AbstractController
{
    public function __construct(
        private readonly FindQuestionByIdUseCase $findQuestionByIdUseCase
    ) {
    }

    #[Route(path: '/question/edit/{id}/{quizId}', name: 'question.edit', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');

        /** @var string $quizId */
        $quizId = $request->get('quizId', '');
        $input = new ByIdInputData($id);

        try {
            $question = $this->findQuestionByIdUseCase->execute($input);
        } catch (CouldNotFindQuestionException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('question.index', [ 'quizId' => $quizId ]);
        }

        return $this->render('question/edit.html.twig', [ 'record' => $question, 'quizId' => $quizId ]);
    }
}
