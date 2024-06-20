<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Question\DeleteQuestionById\DeleteQuestionByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteQuestionController extends AbstractController
{
    public function __construct(private readonly DeleteQuestionByIdUseCase $deleteQuestionByIdUseCase)
    {
    }

    #[Route(path: '/question/delete/{id}/{quizId}', name: 'question.delete', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');

        /** @var string $quizId */
        $quizId = $request->get('quizId', '');

        $input = new ByIdInputData($id);
        $this->deleteQuestionByIdUseCase->execute($input);
        $this->addFlash('success', 'Question successfully deleted');
        return $this->redirectToRoute('question.index', [ 'quizId' => $quizId ]);
    }
}
