<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Quiz;

use App\Code\Application\UseCase\Quiz\CreateQuiz\CreateQuizUseCase;
use App\Code\Application\UseCase\Quiz\CreateQuiz\Data\InputData;
use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreQuizController extends AbstractController
{
    public function __construct(private readonly CreateQuizUseCase $createQuizUseCase)
    {
    }

    #[Route(path: '/quiz/store', name: 'quiz.store', methods: [ 'POST' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $name */
        $name = $request->get('name', '');
        $input = new InputData($name);

        try {
            $this->createQuizUseCase->execute($input);
        } catch (InvalidQuizException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('quiz.create');
        }

        return $this->redirectToRoute('quiz.index');
    }
}
