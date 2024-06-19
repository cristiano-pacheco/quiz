<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use App\Code\Application\UseCase\Question\UpdateQuestion\Data\InputData;
use App\Code\Application\UseCase\Question\UpdateQuestion\UpdateQuestionUseCase;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateQuestionController extends AbstractController
{
    public function __construct(private readonly UpdateQuestionUseCase $updateQuestionUseCase)
    {
    }

    #[Route(path: '/question/update/{id}', name: 'question.update', methods: [ 'POST' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');

        /** @var string $quizId */
        $quizId = $request->get('quiz_id', '');

        /** @var string $question */
        $question = $request->get('question', '');

        /** @var string $sortOrder */
        $sortOrder = $request->get('sort_order', '0');

        $input = new InputData(id: $id, quizId: $quizId, question: $question, sortOrder: (int)$sortOrder);

        try {
            $this->updateQuestionUseCase->execute($input);
            $this->addFlash('success', 'Quiz updated successfully');
        } catch (InvalidQuestionException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('question.edit', [ 'id' => $id ]);
        }

        return $this->redirectToRoute('question.index', [ 'quizId' => $quizId ]);
    }
}
