<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizList\Mapper;

use App\Code\Application\UseCase\Quiz\FindQuizList\Data\OutputData;
use App\Code\Application\UseCase\Quiz\Mapper\QuizToQuizDataMapper;
use App\Code\Domain\Model\Quiz\Quiz;

readonly class QuizToOutputDataMapper
{
    public function __construct(public QuizToQuizDataMapper $quizToQuizDataMapper)
    {
    }

    /**
     * @param Quiz[] $quizListModel
     */
    public function map(array $quizListModel): OutputData
    {
        $quizList = [];
        foreach ($quizListModel as $quiz) {
            if (!$quiz instanceof Quiz) {
                throw new \InvalidArgumentException('Invalid quiz list');
            }
            $quizList[] = $this->quizToQuizDataMapper->map($quiz);
        }
        return new OutputData(quizList: $quizList);
    }
}
