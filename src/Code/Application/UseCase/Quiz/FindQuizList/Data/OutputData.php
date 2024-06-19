<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizList\Data;

use App\Code\Application\UseCase\Quiz\Data\QuizData;

readonly class OutputData
{
    /**
     * @param QuizData[] $quizList
     */
    public function __construct(public array $quizList)
    {
    }
}
