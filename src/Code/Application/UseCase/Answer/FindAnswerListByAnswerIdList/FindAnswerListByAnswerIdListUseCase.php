<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByAnswerIdList;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId\Data\OutputData;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionId\Mapper\AnswerListToOutputDataMapper;
use App\Code\Application\UseCase\Answer\FindAnswerListByQuestionIdList\Mapper\InputDataToIdListMapper;
use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class FindAnswerListByAnswerIdListUseCase
{
    public function __construct(
        private AnswerRepositoryInterface $answerRepository,
        private AnswerListToOutputDataMapper $answerListToOutputDataMapper,
        private InputDataToIdListMapper $inputToIdListMapper
    ) {
    }

    /**
     * @param ByIdInputData[] $input
     * @throws CouldNotFindAnswerException
     */
    public function execute(array $input): OutputData
    {
        $answerIdList = $this->inputToIdListMapper->map($input);
        $answerList = $this->answerRepository->findAnswerListByAnswerIdList($answerIdList);
        return $this->answerListToOutputDataMapper->map($answerList);
    }
}
