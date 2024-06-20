<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByQuestionIdList\Data;

use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class InputData
{
    /**
     * @param ByIdInputData[] $questionIds
     */
    public function __construct(public array $questionIds)
    {
    }
}
