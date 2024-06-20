<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\UpdateAnswer;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Exception\Answer\CouldNotUpdateAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Answer\Data\AnswerData;
use App\Code\Application\UseCase\Answer\Mapper\AnswerToAnswerDataMapper;
use App\Code\Application\UseCase\Answer\UpdateAnswer\Data\InputData;
use App\Code\Application\UseCase\Answer\UpdateAnswer\Mapper\InputDataToAnswerMapper;
use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Exception\Quiz\InvalidBehaviorEnumValueException;
use App\Code\Domain\Exception\Quiz\InvalidRestrictionEnumValueException;

readonly class UpdateAnswerUseCase
{
    public function __construct(
        private AnswerRepositoryInterface $answerRepository,
        private AnswerToAnswerDataMapper $answerToAnswerDataMapper,
        private InputDataToAnswerMapper $inputToAnswerMapper
    ) {
    }

    /**
     * @throws CouldNotUpdateAnswerException
     * @throws InvalidAnswerException
     * @throws InvalidBehaviorEnumValueException
     * @throws InvalidRestrictionEnumValueException
     */
    public function execute(InputData $input): AnswerData
    {
        try {
            $this->answerRepository->findById($input->id);
        } catch (CouldNotFindAnswerException $e) {
            throw new CouldNotUpdateAnswerException($e->getMessage(), $e->getCode(), $e);
        }

        $answer = $this->inputToAnswerMapper->map($input);
        $this->answerRepository->update($answer);
        return $this->answerToAnswerDataMapper->map($answer);
    }
}
