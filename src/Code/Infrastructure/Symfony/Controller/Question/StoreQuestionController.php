<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use App\Code\Application\UseCase\Question\CreateQuestion\CreateQuestionUseCase;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Infrastructure\Symfony\Controller\Question\Mapper\StoreQuestionInputMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreQuestionController extends AbstractController
{
    public function __construct(
        private readonly CreateQuestionUseCase $createQuestionUseCase,
        private readonly StoreQuestionInputMapper $storeQuestionInputMapper
    ) {
    }

    #[Route(path: '/question/store', name: 'question.store', methods: [ 'POST' ])]
    public function __invoke(Request $request): Response
    {
        $input = $this->storeQuestionInputMapper->map($request);

        try {
            $this->createQuestionUseCase->execute($input);
        } catch (InvalidQuestionException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('question.create', [ 'quizId' => $input->quizId ]);
        }

        return $this->redirectToRoute('question.index', [ 'quizId' => $input->quizId ]);
    }
}
