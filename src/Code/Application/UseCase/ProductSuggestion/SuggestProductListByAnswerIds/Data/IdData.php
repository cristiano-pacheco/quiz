<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerIds\Data;

readonly class IdData
{
    public function __construct(
        public string $id
    ) {
    }
}
