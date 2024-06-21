<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\FindAnswerListByAnswerIdList\Mapper;

use App\Code\Application\UseCase\Data\ByIdInputData;
use InvalidArgumentException;

class InputDataToIdListMapper
{
    public function map(array $input): array
    {
        $result = [];

        foreach ($input as $data) {
            if (!$data instanceof ByIdInputData) {
                throw new InvalidArgumentException('The input is not an instance of ByIdInputData class');
            }

            $result[] = $data->id;
        }

        return $result;
    }
}
