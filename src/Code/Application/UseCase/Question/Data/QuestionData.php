<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\Data;

readonly class QuestionData
{
    public function __construct(
        public string $id,
        public string $quizId,
        public string $question,
        public int $sortOrder
    ) {
    }
}
