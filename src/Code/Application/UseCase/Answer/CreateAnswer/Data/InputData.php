<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\CreateAnswer\Data;

readonly class InputData
{
    public function __construct(
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
