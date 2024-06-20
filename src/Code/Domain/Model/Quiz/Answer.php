<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz;

use App\Code\Domain\Exception\InvalidUuidException;
use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Exception\ValidationException;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use App\Code\Domain\Model\Support\Id;
use App\Code\Domain\Validator\Validator;

readonly class Answer
{
    /**
     * @param Id[] $excludedProductIds
     * @param Id[] $recommendedProductIds
     * @throws InvalidAnswerException
     */
    private function __construct(
        public Id $id,
        public Id $questionId,
        public string $answer,
        public int $sortOrder,
        public BehaviorEnum $behavior,
        public RestrictionEnum $restriction,
        public ?Id $questionIdToAsk = null,
        public array $excludedProductIds = [],
        public array $recommendedProductIds = [],
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidAnswerException
     */
    public static function create(
        string $questionId,
        string $answer,
        int $sortOrder,
        BehaviorEnum $behavior,
        RestrictionEnum $restriction,
        ?string $questionIdToAsk = null,
        array $excludedProductIds = [],
        array $recommendedProductIds = []
    ): self {
        $id = Id::create();

        if ($excludedProductIds && $restriction !== RestrictionEnum::EXCLUDE_PRODUCTS) {
            $excludedProductIds = [];
        }

        if ($recommendedProductIds && $behavior !== BehaviorEnum::RECOMMEND_PRODUCTS) {
            $recommendedProductIds = [];
        }

        if ($questionIdToAsk && $behavior !== BehaviorEnum::ASK_QUESTION) {
            $questionIdToAsk = null;
        }

        try {
            $questionIdVo = Id::restore($questionId);
            $questionIdToAskVo = null;
            if ($questionIdToAsk) {
                $questionIdToAskVo = Id::restore($questionIdToAsk);
            }
            $excludedProductIdsVo = self::getProductIds($excludedProductIds);
            $recommendedProductIdsVo = self::getProductIds($recommendedProductIds);
        } catch (InvalidUuidException $e) {
            $message = "The Answer is not valid: {$e->getMessage()}";
            throw new InvalidAnswerException($message, $e->getCode(), $e);
        }

        return new self(
            id: $id,
            questionId: $questionIdVo,
            answer: $answer,
            sortOrder: $sortOrder,
            behavior: $behavior,
            restriction: $restriction,
            questionIdToAsk: $questionIdToAskVo,
            excludedProductIds: $excludedProductIdsVo,
            recommendedProductIds: $recommendedProductIdsVo
        );
    }

    /**
     * @throws InvalidAnswerException
     */
    public static function restore(
        string $id,
        string $questionId,
        string $answer,
        int $sortOrder,
        BehaviorEnum $behavior,
        RestrictionEnum $restriction,
        ?string $questionIdToAsk = null,
        array $excludedProductIds = [],
        array $recommendedProductIds = []
    ): self {
        if ($excludedProductIds && $restriction !== RestrictionEnum::EXCLUDE_PRODUCTS) {
            $excludedProductIds = [];
        }

        if ($recommendedProductIds && $behavior !== BehaviorEnum::RECOMMEND_PRODUCTS) {
            $recommendedProductIds = [];
        }

        if ($questionIdToAsk && $behavior !== BehaviorEnum::ASK_QUESTION) {
            $questionIdToAsk = null;
        }

        try {
            $idVo = Id::restore($id);
            $questionIdVo = Id::restore($questionId);
            $questionIdToAskVo = null;
            if ($questionIdToAsk) {
                $questionIdToAskVo = Id::restore($questionIdToAsk);
            }
            $excludedProductIdsVo = self::getProductIds($excludedProductIds);
            $recommendedProductIdsVo = self::getProductIds($recommendedProductIds);
        } catch (InvalidUuidException $e) {
            $message = "The Answer is not valid: {$e->getMessage()}";
            throw new InvalidAnswerException($message, $e->getCode(), $e);
        }

        return new self(
            id: $idVo,
            questionId: $questionIdVo,
            answer: $answer,
            sortOrder: $sortOrder,
            behavior: $behavior,
            restriction: $restriction,
            questionIdToAsk: $questionIdToAskVo,
            excludedProductIds: $excludedProductIdsVo,
            recommendedProductIds: $recommendedProductIdsVo
        );
    }

    /**
     * @throws InvalidAnswerException
     */
    private function validate(): void
    {
        if ($this->behavior === BehaviorEnum::ASK_QUESTION) {
            Validator::notEmpty(
                key: 'questionIdToAsk',
                value: $this->questionIdToAsk,
                message: 'The question id to ask is required',
            );
        }

        if ($this->behavior === BehaviorEnum::RECOMMEND_PRODUCTS) {
            Validator::notEmpty(
                key: 'recommendedProductIds',
                value: $this->recommendedProductIds,
                message: 'At least one recommended product id is required when the behavior is to recommend products',
            );
        }

        if ($this->restriction === RestrictionEnum::EXCLUDE_PRODUCTS) {
            Validator::notEmpty(
                key: 'excludedProductIds',
                value: $this->excludedProductIds,
                message: 'At least one excluded product id is required when the restriction is to exclude products',
            );
        }

        Validator::minMax(
            key: 'answer',
            value: $this->answer,
            message: 'The answer must contain between 2 and 255 characters',
            min: 2,
            max: 255
        );

        Validator::positiveNumber(
            key: 'sortOrder',
            value: $this->sortOrder,
            message: 'The sortOrder must be a positive number',
        );

        try {
            Validator::validate('The Answer is not valid');
        } catch (ValidationException $e) {
            throw new InvalidAnswerException("The Answer is not valid", $e->getCode(), $e, $e->getErrors());
        }
    }

    /**
     * @return Id[]
     * @throws InvalidUuidException
     */
    private static function getProductIds(array $productIds): array
    {
        $productIdsVo = [];

        if (!$productIds) {
            return $productIdsVo;
        }

        foreach ($productIds as $productId) {
            $productIdsVo[] = Id::restore($productId);
        }

        return $productIdsVo;
    }
}
