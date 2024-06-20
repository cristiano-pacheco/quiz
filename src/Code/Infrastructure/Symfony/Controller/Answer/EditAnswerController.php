<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Answer\FindAnswerById\FindAnswerByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditAnswerController extends AbstractController
{
    public function __construct(
        private readonly FindAnswerByIdUseCase $findAnswerByIdUseCase
    ) {
    }

    #[Route(path: '/answer/edit/{id}/{questionId}', name: 'answer.edit', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');

        /** @var string $questionId */
        $questionId = $request->get('questionId', '');
        $input = new ByIdInputData($id);

        try {
            $answer = $this->findAnswerByIdUseCase->execute($input);
        } catch (CouldNotFindAnswerException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('answer.index', [ 'questionId' => $questionId ]);
        }

        return $this->render('answer/edit.html.twig', [ 'record' => $answer, 'questionId' => $questionId ]);
    }
}
