<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\UpdateQuestion\Data;

readonly class InputData
{
    public function __construct(
        public string $id,
        public string $quizId,
        public string $question,
        public int $sortOrder
    ) {
    }
}
