<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Quiz;

use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Quiz\FindQuizById\FindQuizByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditQuizController extends AbstractController
{
    public function __construct(
        private readonly FindQuizByIdUseCase $findQuizByIdUseCase
    ) {
    }

    #[Route(path: '/quiz/edit/{id}', name: 'quiz.edit', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');
        $input = new ByIdInputData(id: $id);

        try {
            $quiz = $this->findQuizByIdUseCase->execute($input);
        } catch (CouldNotFindQuizException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('quiz.index');
        }

        return $this->render('quiz/edit.html.twig', [ 'record' => $quiz ]);
    }
}
