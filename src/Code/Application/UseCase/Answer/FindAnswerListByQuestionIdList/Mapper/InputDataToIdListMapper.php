<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByQuestionIdList\Mapper;

use App\Code\Application\UseCase\Data\ByIdInputData;
use InvalidArgumentException;

class InputDataToIdListMapper
{
    public function map(array $input): array
    {
        $result = [];

        foreach ($input as $input) {
            if (!$input instanceof ByIdInputData) {
                throw new InvalidArgumentException('The input is not an instance of ByIdInputData class');
            }

            $result[] = $input->id;
        }

        return $result;
    }
}
