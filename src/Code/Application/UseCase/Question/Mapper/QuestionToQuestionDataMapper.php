<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\Mapper;

use App\Code\Application\UseCase\Question\Data\QuestionData;
use App\Code\Domain\Model\Quiz\Question;

class QuestionToQuestionDataMapper
{
    public function map(Question $question): QuestionData
    {
        return new QuestionData(
            id: $question->id->value->toString(),
            quizId: $question->quizId->value->toString(),
            question: $question->question,
            sortOrder: $question->sortOrder
        );
    }
}
