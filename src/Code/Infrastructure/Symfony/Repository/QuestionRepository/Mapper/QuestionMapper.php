<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Mapper;

use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Domain\Model\Quiz\Question;

class QuestionMapper
{
    /**
     * @throws InvalidQuestionException
     */
    public function map(array $data): Question
    {
        return Question::restore(
            id: $data['id'],
            quizId: $data['quiz_id'],
            question: $data['question'],
            sortOrder: (int)$data['sort_order'],
        );
    }
}
