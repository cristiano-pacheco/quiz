<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Data;

readonly class OutputData
{
    public function __construct(public QuizData $quiz)
    {
    }
}
