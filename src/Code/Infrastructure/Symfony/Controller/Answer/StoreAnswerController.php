<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\UseCase\Answer\CreateAnswer\CreateAnswerUseCase;
use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Infrastructure\Symfony\Controller\Answer\Mapper\StoreAnswerInputMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreAnswerController extends AbstractController
{
    public function __construct(
        private readonly CreateAnswerUseCase $createAnswerUseCase,
        private readonly StoreAnswerInputMapper $storeAnswerInputMapper
    ) {
    }

    #[Route(path: '/answer/store', name: 'answer.store', methods: [ 'POST' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $quizId */
        $quizId = $request->get('quiz_id', '');

        $input = $this->storeAnswerInputMapper->map($request);

        try {
            $this->createAnswerUseCase->execute($input);
        } catch (InvalidAnswerException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);

            $data = [ 'quizId' => $quizId, 'questionId' => $input->questionId ];
            return $this->redirectToRoute('answer.create', $data);
        }

        return $this->redirectToRoute('answer.index', [ 'questionId' => $input->questionId ]);
    }
}
