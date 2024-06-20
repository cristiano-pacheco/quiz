<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Data;
use App\Code\Application\UseCase\Answer\Data\AnswerData;
use App\Code\Application\UseCase\Question\Data\QuestionData as DefaultQuestionData;

class QuestionData
{
    /**
     * @param AnswerData[] $answerList
     */
    public function __construct(
        public DefaultQuestionData $question,
        public array $answerList
    ) {
    }
}
