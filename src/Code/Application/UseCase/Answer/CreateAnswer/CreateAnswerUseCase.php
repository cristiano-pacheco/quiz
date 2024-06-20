<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\CreateAnswer;

use App\Code\Application\Exception\Answer\CouldNotCreateAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Answer\CreateAnswer\Data\InputData;
use App\Code\Application\UseCase\Answer\CreateAnswer\Mapper\InputDataToAnswerMapper;
use App\Code\Application\UseCase\Answer\Data\AnswerData;
use App\Code\Application\UseCase\Answer\Mapper\AnswerToAnswerDataMapper;
use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Exception\Quiz\InvalidBehaviorEnumValueException;
use App\Code\Domain\Exception\Quiz\InvalidRestrictionEnumValueException;

readonly class CreateAnswerUseCase
{
    public function __construct(
        private AnswerRepositoryInterface $AnswerRepository,
        private AnswerToAnswerDataMapper $answerToAnswerDataMapper,
        private InputDataToAnswerMapper $inputToAnswerMapper
    ) {
    }

    /**
     * @throws CouldNotCreateAnswerException
     * @throws InvalidAnswerException
     * @throws InvalidBehaviorEnumValueException
     * @throws InvalidRestrictionEnumValueException
     */
    public function execute(InputData $input): AnswerData
    {
        $answer = $this->inputToAnswerMapper->map($input);
        $this->AnswerRepository->create($answer);
        return $this->answerToAnswerDataMapper->map($answer);
    }
}
