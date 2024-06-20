<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Data;
use App\Code\Application\UseCase\Quiz\Data\QuizData as DefaultQuizData;

readonly class QuizData
{
    /**
     * @param QuestionData[] $questionList
     */
    public function __construct(public DefaultQuizData $quiz, public array $questionList)
    {
    }
}
