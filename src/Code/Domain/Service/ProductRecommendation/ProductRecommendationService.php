<?php

declare(strict_types=1);

namespace App\Code\Domain\Service\ProductRecommendation;

use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use App\Code\Domain\Service\ProductRecommendation\Data\Input;
use App\Code\Domain\Service\ProductRecommendation\Data\Output;
use App\Code\Domain\Service\ProductRecommendation\Exception\InvalidProductRecommendationInputException;
use App\Code\Domain\Service\ProductRecommendation\Registry\ProductRegistry;
use App\Code\Domain\Service\ProductRecommendation\Validator\InputValidator;

readonly class ProductRecommendationService
{
    public function __construct(
        private InputValidator $inputValidator,
        private ProductRegistry $productRegistry
    ) {
    }

    /**
     * @throws InvalidProductRecommendationInputException
     */
    public function execute(Input $input): Output
    {
        $this->inputValidator->validate($input);

        foreach ($input->answers as $answer) {
            if (
                $answer->behavior === BehaviorEnum::EXCLUDE_ALL_PRODUCTS ||
                $answer->restriction === RestrictionEnum::EXCLUDE_ALL_PRODUCTS
            ) {
                $this->productRegistry->reset();
                return new Output();
            }

            if ($answer->behavior === BehaviorEnum::RECOMMEND_PRODUCTS) {
                foreach ($answer->recommendedProductIds as $productId) {
                    $this->productRegistry->add($productId);
                }
            }

            if ($answer->restriction === RestrictionEnum::EXCLUDE_PRODUCTS) {
                foreach ($answer->excludedProductIds as $productId) {
                    $this->productRegistry->remove($productId);
                }
            }
        }

        return new Output($this->productRegistry->productIds());
    }
}
