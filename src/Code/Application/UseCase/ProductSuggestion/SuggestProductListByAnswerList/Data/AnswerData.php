<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\Data;

readonly class AnswerData
{
    public function __construct(
        public string $id,
        public string $questionId,
        public string $answer,
        public int $sortOrder,
        public string $behavior,
        public string $restriction,
        public string $questionIdToAsk = '',
        public array $excludedProductIds = [],
        public array $recommendedProductIds = []
    ) {
    }
}
