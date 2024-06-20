<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByQuizId\Data;

use App\Code\Application\UseCase\Answer\Data\AnswerData;

readonly class OutputData
{
    /**
     * @param AnswerData[] $answerList
     */
    public function __construct(public array $answerList)
    {
    }
}
