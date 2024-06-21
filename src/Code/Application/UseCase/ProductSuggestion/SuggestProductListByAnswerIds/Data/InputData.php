<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerIds\Data;

readonly class InputData
{
    /**
     * @param string[] $idList
     */
    public function __construct(
        public array $idList
    ) {
    }
}
