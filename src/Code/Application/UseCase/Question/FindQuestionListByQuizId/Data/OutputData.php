<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\FindQuestionListByQuizId\Data;

use App\Code\Application\UseCase\Question\Data\QuestionData;

readonly class OutputData
{
    /**
     * @param QuestionData[] $questionList
     */
    public function __construct(public array $questionList)
    {
    }
}
