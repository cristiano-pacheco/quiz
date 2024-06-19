<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\Mapper;

use App\Code\Application\UseCase\Quiz\Data\QuizData;
use App\Code\Domain\Model\Quiz\Quiz;

class QuizToQuizDataMapper
{
    public function map(Quiz $quiz): QuizData
    {
        return new QuizData(id: $quiz->id->value->toString(), name: $quiz->name);
    }
}
