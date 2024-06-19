<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Quiz;

use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Quiz\DeleteQuizById\DeleteQuizByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteQuizController extends AbstractController
{
    public function __construct(private readonly DeleteQuizByIdUseCase $deleteQuizByIdUseCase)
    {
    }

    #[Route(path: '/quiz/delete/{id}', name: 'quiz.delete', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id');
        $input = new ByIdInputData(id: $id);
        $this->deleteQuizByIdUseCase->execute($input);
        $this->addFlash('success', 'Quiz successfully deleted');
        return $this->redirectToRoute('quiz.index');
    }
}
