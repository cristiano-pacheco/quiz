<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer\Mapper;

use App\Code\Application\UseCase\Answer\UpdateAnswer\Data\InputData;
use Symfony\Component\HttpFoundation\Request;

class UpdateAnswerInputMapper
{
    public function map(Request $request): InputData
    {
        $payload = $request->getPayload()->all();

        return new InputData(
            id: $payload['id'] ?? '',
            questionId: $payload['questionId'] ?? '',
            answer: $payload['answer'] ?? '',
            sortOrder: (int)($payload['sort_order'] ?? ''),
            behavior: $payload['behavior'] ?? '',
            restriction: $payload['restriction'] ?? '',
            questionIdToAsk: $payload['question_id_to_ask'] ?? '',
            excludedProductIds: $payload['excluded_product_ids'] ?? [],
            recommendedProductIds: $payload['recommended_product_ids'] ?? [],
        );
    }
}
