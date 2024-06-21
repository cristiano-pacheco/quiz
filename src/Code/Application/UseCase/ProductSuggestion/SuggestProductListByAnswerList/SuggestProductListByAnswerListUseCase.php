<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList;

use App\Code\Application\UseCase\Product\FindProductListByIdList\FindProductListByIdListUseCase;
use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\Data\InputData;
use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\Data\OutputData;
use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\Mapper\InputDataToAnswerMapper;
use App\Code\Domain\Model\Support\Id;
use App\Code\Domain\Service\ProductRecommendation\Data\Input;
use App\Code\Domain\Service\ProductRecommendation\Data\Output;
use App\Code\Domain\Service\ProductRecommendation\ProductRecommendationService;

readonly class SuggestProductListByAnswerListUseCase
{
    public function __construct(
        private ProductRecommendationService $productRecommendationService,
        private FindProductListByIdListUseCase $findProductListByIdListUseCase,
        private InputDataToAnswerMapper $answerMapper
    ) {
    }

    public function execute(InputData $input): OutputData
    {
        $answerList = [];
        foreach ($input->answerList as $answer) {
            $answerList[] = $this->answerMapper->map($answer);
        }
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
