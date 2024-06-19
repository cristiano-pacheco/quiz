<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\FindQuestionListByQuizId;

use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Repository\QuestionRepositoryInterface;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Question\FindQuestionListByQuizId\Data\OutputData;
use App\Code\Application\UseCase\Question\FindQuestionListByQuizId\Mapper\QuestionListToOutputDataMapper;

readonly class FindQuestionListByQuizIdUseCase
{
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
        private QuestionListToOutputDataMapper $questionListToOutputDataMapper
    ) {
    }

    /**
     * @throws CouldNotFindQuestionException
     */
    public function execute(ByIdInputData $inputData): OutputData
    {
        $QuestionList = $this->questionRepository->findQuestionListByQuizId($inputData->id);
        return $this->questionListToOutputDataMapper->map($QuestionList);
    }
}
