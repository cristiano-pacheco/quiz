<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\Mapper;

use App\Code\Application\UseCase\Answer\Data\AnswerData;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Model\Support\Id;

class AnswerToAnswerDataMapper
{
    public function map(Answer $answer): AnswerData
    {
        $excludedProductIds = $this->mapArrayIds($answer->excludedProductIds);
        $recommendedProductIds = $this->mapArrayIds($answer->recommendedProductIds);

        return new AnswerData(
            id: $answer->id->value->toString(),
            questionId: $answer->questionId->value->toString(),
            answer: $answer->answer,
            sortOrder: $answer->sortOrder,
            behavior: $answer->behavior->value,
            restriction: $answer->restriction->value,
            questionIdToAsk: $answer->questionIdToAsk ? $answer->questionIdToAsk->value->toString() : '',
            excludedProductIds: $excludedProductIds,
            recommendedProductIds: $recommendedProductIds,
        );
    }

    private function mapArrayIds(?array $ids): array
    {
        if (!$ids) {
            return [];
        }

        $mappedIds = [];
        foreach ($ids as $id) {
            if (!$id instanceof Id) {
                continue;
            }
            $mappedIds[] = $id->value->toString();
        }

        return $mappedIds;
    }
}
