<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Answer\DeleteAnswerById\DeleteAnswerByIdUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteAnswerController extends AbstractController
{
    public function __construct(private readonly DeleteAnswerByIdUseCase $deleteAnswerByIdUseCase)
    {
    }

    #[Route(path: '/answer/delete/{id}/{questionId}', name: 'answer.delete', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');

        /** @var string $questionId */
        $questionId = $request->get('questionId', '');

        $input = new ByIdInputData($id);
        $this->deleteAnswerByIdUseCase->execute($input);
        $this->addFlash('success', 'Answer successfully deleted');
        return $this->redirectToRoute('answer.index', [ 'questionId' => $questionId ]);
    }
}
