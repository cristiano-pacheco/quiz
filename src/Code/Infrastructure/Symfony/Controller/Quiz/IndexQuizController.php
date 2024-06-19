<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Quiz;

use App\Code\Application\UseCase\Quiz\FindQuizList\FindQuizListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexQuizController extends AbstractController
{
    public function __construct(private readonly FindQuizListUseCase $findQuizListUseCase)
    {
    }

    #[Route(path: '/quiz', name: 'quiz.index', methods: ['GET'])]
    public function __invoke(): Response
    {
        $output = $this->findQuizListUseCase->execute();
        return $this->render('quiz/index.html.twig', ['records' => $output->quizList]);
    }
}
