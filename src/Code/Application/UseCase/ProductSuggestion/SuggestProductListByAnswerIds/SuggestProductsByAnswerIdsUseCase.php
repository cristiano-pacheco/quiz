<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerIds;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Exception\Product\CouldNotFindProductException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Product\FindProductListByIdList\FindProductListByIdListUseCase;
use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerIds\Data\InputData;
use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\Data\OutputData;
use App\Code\Domain\Model\Support\Id;
use App\Code\Domain\Service\ProductRecommendation\Data\Input;
use App\Code\Domain\Service\ProductRecommendation\Data\Output;
use App\Code\Domain\Service\ProductRecommendation\Exception\InvalidProductRecommendationInputException;
use App\Code\Domain\Service\ProductRecommendation\ProductRecommendationService;

readonly class SuggestProductsByAnswerIdsUseCase
{
    public function __construct(
        private ProductRecommendationService $productRecommendationService,
        private FindProductListByIdListUseCase $findProductListByIdListUseCase,
        private AnswerRepositoryInterface $answerRepository
    ) {
    }

    /**
     * @throws CouldNotFindAnswerException
     * @throws CouldNotFindProductException
     * @throws InvalidProductRecommendationInputException
     */
    public function execute(InputData $input): OutputData
    {
        $answerList = $this->answerRepository->findAnswerListByAnswerIdList($input->idList);
        $serviceInput = new Input($answerList);
        $productListModel = $this->productRecommendationService->execute($serviceInput);
        $productIdList = $this->mapIds($productListModel);
        $productListData = $this->findProductListByIdListUseCase->execute($productIdList);

        return new OutputData($productListData->productList);
    }

    private function mapIds(Output $output): array
    {
        $productIdList = [];
        foreach ($output->productIds as $id) {
            if (!$id instanceof Id) {
                continue;
            }
            $productIdList[] = $id->value->toString();
        }
        return $productIdList;
    }
}
