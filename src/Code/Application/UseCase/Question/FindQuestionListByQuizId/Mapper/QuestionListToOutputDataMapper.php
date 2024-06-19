<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\FindQuestionListByQuizId\Mapper;

use App\Code\Application\UseCase\Question\FindQuestionListByQuizId\Data\OutputData;
use App\Code\Application\UseCase\Question\Mapper\QuestionToQuestionDataMapper;
use App\Code\Domain\Model\Quiz\Question;

readonly class QuestionListToOutputDataMapper
{
    public function __construct(public QuestionToQuestionDataMapper $questionToQuestionDataMapper)
    {
    }

    /**
     * @param Question[] $questionsModel
     */
    public function map(array $questionsModel): OutputData
    {
        $questionList = [];
        foreach ($questionsModel as $question) {
            if (!$question instanceof Question) {
                throw new \InvalidArgumentException('Invalid question list');
            }
            $questionList[] = $this->questionToQuestionDataMapper->map($question);
        }
        return new OutputData($questionList);
    }
}
