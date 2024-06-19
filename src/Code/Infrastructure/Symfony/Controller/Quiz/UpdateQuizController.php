<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Quiz;

use App\Code\Application\UseCase\Quiz\UpdateQuiz\Data\InputData;
use App\Code\Application\UseCase\Quiz\UpdateQuiz\UpdateQuizUseCase;
use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateQuizController extends AbstractController
{
    public function __construct(private readonly UpdateQuizUseCase $updateQuizUseCase)
    {
    }

    #[Route(path: '/quiz/update/{id}', name: 'quiz.update', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');

        /** @var string $name */
        $name = $request->get('name', '');
        $input = new InputData($id, $name);

        try {
            $this->updateQuizUseCase->execute($input);
            $this->addFlash('success', 'Quiz updated successfully');
        } catch (InvalidQuizException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('quiz.edit', ['id' => $id]);
        }

        return $this->redirectToRoute('quiz.index');
    }
}
