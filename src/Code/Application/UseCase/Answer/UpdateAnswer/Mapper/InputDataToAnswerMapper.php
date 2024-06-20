<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\UpdateAnswer\Mapper;

use App\Code\Application\UseCase\Answer\UpdateAnswer\Data\InputData;
use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Exception\Quiz\InvalidBehaviorEnumValueException;
use App\Code\Domain\Exception\Quiz\InvalidRestrictionEnumValueException;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;

class InputDataToAnswerMapper
{
    /**
     * @throws InvalidAnswerException
     * @throws InvalidBehaviorEnumValueException
     * @throws InvalidRestrictionEnumValueException
     */
    public function map(InputData $input): Answer
    {
        return Answer::restore(
            id: $input->id,
            questionId: $input->questionId,
            answer: $input->answer,
            sortOrder: $input->sortOrder,
            behavior: BehaviorEnum::fromString($input->behavior),
            restriction: RestrictionEnum::fromString($input->restriction),
            questionIdToAsk: $input->questionIdToAsk,
            excludedProductIds: $input->excludedProductIds,
            recommendedProductIds: $input->recommendedProductIds
        );
    }
}
