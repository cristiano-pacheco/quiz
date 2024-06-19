<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\CreateQuestion\Data;

readonly class InputData
{
    public function __construct(
        public string $quizId,
        public string $question,
        public int $sortOrder
    ) {
    }
}
