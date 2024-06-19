<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use App\Code\Application\UseCase\Question\CreateQuestion\CreateQuestionUseCase;
use App\Code\Application\UseCase\Question\CreateQuestion\Data\InputData;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreQuestionController extends AbstractController
{
    public function __construct(private readonly CreateQuestionUseCase $createQuestionUseCase)
    {
    }

    #[Route(path: '/question/store', name: 'question.store', methods: [ 'POST' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $quizId */
        $quizId = $request->get('quiz_id', '');

        /** @var string $question */
        $question = $request->get('question', '');

        /** @var string $sortOrder */
        $sortOrder = $request->get('sort_order', '0');
        $input = new InputData(quizId: $quizId, question: $question, sortOrder: (int)$sortOrder);

        try {
            $this->createQuestionUseCase->execute($input);
        } catch (InvalidQuestionException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('question.create', [ 'quizId' => $quizId ]);
        }

        return $this->redirectToRoute('question.index', [ 'quizId' => $quizId ]);
    }
}
