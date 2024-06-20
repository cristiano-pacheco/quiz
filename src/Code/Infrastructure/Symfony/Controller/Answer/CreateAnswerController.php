<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Product\FindProductList\FindProductListUseCase;
use App\Code\Application\UseCase\Question\FindQuestionListByQuizId\FindQuestionListByQuizIdUseCase;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateAnswerController extends AbstractController
{
    public function __construct(
        private readonly FindProductListUseCase $findProductListUseCase,
        private readonly FindQuestionListByQuizIdUseCase $findQuestionListByQuizIdUseCase
    ) {
    }

    #[Route(path: '/answer/create/{quizId}/{questionId}', name: 'answer.create', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
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

        $data = [
            'question' => $question,
            'behaviorList' => $behaviors,
            'restrictionList' => $restrictions,
            'productList' => $productList->productList,
            'questionList' => $questionList->questionList,
        ];

        return $this->render('answer/create.html.twig', $data);
    }
}
