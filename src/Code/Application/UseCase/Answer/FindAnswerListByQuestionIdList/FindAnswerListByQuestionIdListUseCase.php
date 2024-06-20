<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByQuestionIdList;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId\Data\OutputData;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId\Mapper\AnswerListToOutputDataMapper;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionIdList\Mapper\InputDataToIdListMapper;
use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class FindAnswerListByQuestionIdListUseCase
{
    public function __construct(
        private AnswerRepositoryInterface $answerRepository,
        private AnswerListToOutputDataMapper $answerListToOutputDataMapper,
        private InputDataToIdListMapper $inputDataToIdListMapper
    ) {
    }

    /**
     * @param ByIdInputData[] $input
     * @throws CouldNotFindAnswerException
     */
    public function execute(array $input): OutputData
    {
        $questionIdList = $this->inputDataToIdListMapper->map($input);
        $answerList = $this->answerRepository->findAnswerListByQuestionIdList($questionIdList);
        return $this->answerListToOutputDataMapper->map($answerList);
    }
}
