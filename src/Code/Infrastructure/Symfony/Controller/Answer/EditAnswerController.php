<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\UseCase\Answer\FindAnswerById\FindAnswerByIdUseCase;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Product\FindProductList\FindProductListUseCase;
use App\Code\Application\UseCase\Question\FindQuestionListByQuizId\FindQuestionListByQuizIdUseCase;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditAnswerController extends AbstractController
{
    public function __construct(
        private readonly FindAnswerByIdUseCase $findAnswerByIdUseCase,
        private readonly FindProductListUseCase $findProductListUseCase,
        private readonly FindQuestionListByQuizIdUseCase $findQuestionListByQuizIdUseCase
    ) {
    }

    #[Route(path: '/answer/edit/{id}/{quizId}/{questionId}', name: 'answer.edit', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $id */
        $id = $request->get('id', '');
        /** @var string $quizId */
        $quizId = $request->get('quizId', '');
        /** @var string $questionId */
        $questionId = $request->get('questionId', '');

        $behaviors = BehaviorEnum::toArray();
        $restrictions = RestrictionEnum::toArray();
        $productList = $this->findProductListUseCase->execute();
        $questionList = $this->findQuestionListByQuizIdUseCase->execute(new ByIdInputData($quizId));
        $question = $questionList->questionList[$questionId] ?? null;

        if ($question === null) {
            throw $this->createNotFoundException("The Question with ID: $questionId is not found");
        }

        try {
            $answer = $this->findAnswerByIdUseCase->execute(new ByIdInputData($id));
        } catch (CouldNotFindAnswerException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('answer.index', [ 'questionId' => $questionId ]);
        }

        $data = [
            'record' => $answer,
            'question' => $question,
            'behaviorList' => $behaviors,
            'restrictionList' => $restrictions,
            'productList' => $productList->productList,
            'questionList' => $questionList->questionList,
        ];

        return $this->render('answer/edit.html.twig', $data);
    }
}
