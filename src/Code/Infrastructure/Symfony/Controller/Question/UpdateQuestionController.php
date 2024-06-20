<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use App\Code\Application\UseCase\Question\UpdateQuestion\UpdateQuestionUseCase;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Infrastructure\Symfony\Controller\Question\Mapper\UpdateQuestionInputMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateQuestionController extends AbstractController
{
    public function __construct(
        private readonly UpdateQuestionUseCase $updateQuestionUseCase,
        private readonly UpdateQuestionInputMapper $updateQuestionInputMapper
    ) {
    }

    #[Route(path: '/question/update/{id}', name: 'question.update', methods: [ 'POST' ])]
    public function __invoke(Request $request): Response
    {
        $input = $this->updateQuestionInputMapper->map($request);

        try {
            $this->updateQuestionUseCase->execute($input);
            $this->addFlash('success', 'Question updated successfully');
        } catch (InvalidQuestionException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('question.edit', [ 'id' => $input->id ]);
        }

        return $this->redirectToRoute('question.index', [ 'quizId' => $input->quizId ]);
    }
}
