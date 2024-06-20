<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByQuizId\Mapper;

use App\Code\Application\UseCase\Answer\FindAnswerListByQuizId\Data\OutputData;
use App\Code\Application\UseCase\Answer\Mapper\AnswerToAnswerDataMapper;
use App\Code\Domain\Model\Quiz\Answer;

readonly class AnswerListToOutputDataMapper
{
    public function __construct(public AnswerToAnswerDataMapper $answerToAnswerDataMapper)
    {
    }

    /**
     * @param Answer[] $answersModel
     */
    public function map(array $answersModel): OutputData
    {
        $answerList = [];
        foreach ($answersModel as $answer) {
            if (!$answer instanceof Answer) {
                throw new \InvalidArgumentException('Invalid answer list');
            }
            $answerList[] = $this->answerToAnswerDataMapper->map($answer);
        }
        return new OutputData($answerList);
    }
}
