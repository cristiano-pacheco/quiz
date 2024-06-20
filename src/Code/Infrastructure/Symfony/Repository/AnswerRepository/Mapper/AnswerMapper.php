<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Mapper;

use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Exception\Quiz\InvalidBehaviorEnumValueException;
use App\Code\Domain\Exception\Quiz\InvalidRestrictionEnumValueException;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;

readonly class AnswerMapper
{
    public function __construct(private DecoderInterface $jsonDecode)
    {
    }

    /**
     * @throws InvalidAnswerException
     * @throws InvalidBehaviorEnumValueException
     * @throws InvalidRestrictionEnumValueException
     */
    public function map(array $data): Answer
    {
        $behavior = BehaviorEnum::fromString($data['behavior']);
        $restriction = RestrictionEnum::fromString($data['restriction']);

        $excludedProductIds = $this->decode('excluded_product_ids', $data);
        $recommendedProductIds = $this->decode('recommended_product_ids', $data);

        return Answer::restore(
            id: $data['id'],
            questionId: $data['question_id'],
            answer: $data['answer'],
            sortOrder: (int)$data['sort_order'],
            behavior: $behavior,
            restriction: $restriction,
            questionIdToAsk: $data['question_to_ask'] ?? null,
            excludedProductIds: $excludedProductIds,
            recommendedProductIds: $recommendedProductIds
        );
    }

    // maybe create a custom decode?
    private function decode(string $key, array $data): array
    {
        if (empty($data[$key])) {
            return [];
        }

        $context = [ JsonDecode::ASSOCIATIVE => true ];

        /** @var array $decoded */
        $decoded = $this->jsonDecode->decode($data[$key], 'json', $context);

        return array_map(static fn($id) => $id['value'] ?? '', $decoded);
    }
}
