<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId\Data\OutputData;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId\Mapper\AnswerListToOutputDataMapper;
use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class FindAnswerListByQuestionIdUseCase
{
    public function __construct(
        private AnswerRepositoryInterface $answerRepository,
        private AnswerListToOutputDataMapper $answerListToOutputDataMapper
    ) {
    }

    /**
     * @throws CouldNotFindAnswerException
     */
    public function execute(ByIdInputData $inputData): OutputData
    {
        $answerList = $this->answerRepository->findAnswerListByQuestionId($inputData->id);
        return $this->answerListToOutputDataMapper->map($answerList);
    }
}
