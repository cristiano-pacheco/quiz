<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerById;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Answer\Data\AnswerData;
use App\Code\Application\UseCase\Answer\Mapper\AnswerToAnswerDataMapper;
use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class FindAnswerByIdUseCase
{
    public function __construct(
        private AnswerRepositoryInterface $answerRepository,
        private AnswerToAnswerDataMapper $answerToAnswerDataMapper
    ) {
    }

    /**
     * @throws CouldNotFindAnswerException
     */
    public function execute(ByIdInputData $input): AnswerData
    {
        $Answer = $this->answerRepository->findById($input->id);
        return $this->answerToAnswerDataMapper->map($Answer);
    }
}
