<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer\Mapper;

use App\Code\Application\UseCase\Answer\UpdateAnswer\Data\InputData;
use Symfony\Component\HttpFoundation\Request;

class UpdateAnswerInputMapper
{
    public function map(Request $request): InputData
    {
        /** @var string $id */
        $id = $request->get('id', '');

        $payload = $request->getPayload()->all();

        $excludedProductIds = $this->getIds('excluded_product_id', $payload);
        $recommendedProductIds = $this->getIds('recommended_product_id', $payload);

        return new InputData(
            id: $id,
            questionId: $payload['question_id'] ?? '',
            answer: $payload['answer'] ?? '',
            sortOrder: (int)($payload['sort_order'] ?? ''),
            behavior: $payload['behavior'] ?? '',
            restriction: $payload['restriction'] ?? '',
            questionIdToAsk: $payload['question_id_to_ask'] ?? '',
            excludedProductIds: $excludedProductIds,
            recommendedProductIds: $recommendedProductIds,
        );
    }

    private function getIds(string $key, array $data): array
    {
        $ids = [];
        $id = $data[$key] ?? [];
        if ($id) {
            $ids[] = $id;
        }
        return $ids;
    }
}
