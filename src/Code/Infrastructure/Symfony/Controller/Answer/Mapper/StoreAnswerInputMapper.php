<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer\Mapper;

use App\Code\Application\UseCase\Answer\CreateAnswer\Data\InputData;
use Symfony\Component\HttpFoundation\Request;

class StoreAnswerInputMapper
{
    public function map(Request $request): InputData
    {
        $payload = $request->getPayload()->all();

        return new InputData(
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
