<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\UseCase\Answer\UpdateAnswer\Data\InputData;
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
        $input = $this->updateAnswerInputMapper->map($request);

        try {
            $this->updateAnswerUseCase->execute($input);
            $this->addFlash('success', 'Question updated successfully');
        } catch (InvalidAnswerException $exception) {
            $errors = [];
            foreach ($exception->getErrors() as $error) {
                $errors[] = $error->message;
            }
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('answer.edit', [ 'id' => $input->id ]);
        }

        return $this->redirectToRoute('answer.index', [ 'questionId' => $input->questionId ]);
    }
}
