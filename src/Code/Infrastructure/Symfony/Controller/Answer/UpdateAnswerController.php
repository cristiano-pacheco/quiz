<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\UseCase\Answer\UpdateAnswer\UpdateAnswerUseCase;
use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Infrastructure\Symfony\Controller\Answer\Mapper\UpdateAnswerInputMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateAnswerController extends AbstractController
{
    public function __construct(
        private readonly UpdateAnswerUseCase $updateAnswerUseCase,
        private readonly UpdateAnswerInputMapper $updateAnswerInputMapper
    ) {
    }

    #[Route(path: '/answer/update/{id}', name: 'answer.update', methods: [ 'POST' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $quizId */
        $quizId = $request->get('quiz_id', '');
        /** @var string $questionId */
        $questionId = $request->get('question_id', '');

        $input = $this->updateAnswerInputMapper->map($request);

        try {
            $this->updateAnswerUseCase->execute($input);
            $this->addFlash('success', 'Answer updated successfully');
        } catch (InvalidAnswerException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            $data = [ 'id' => $input->id, 'quizId' => $quizId, 'questionId' => $questionId ];
            return $this->redirectToRoute('answer.edit', $data);
        }

        return $this->redirectToRoute('answer.index', [ 'questionId' => $input->questionId ]);
    }
}
