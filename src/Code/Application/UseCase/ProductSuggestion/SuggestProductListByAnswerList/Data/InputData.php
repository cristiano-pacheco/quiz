<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\Data;

readonly class InputData
{
    /**
     * @param AnswerData[] $answerList
     */
    public function __construct(
        public array $answerList
    ) {
    }
}
