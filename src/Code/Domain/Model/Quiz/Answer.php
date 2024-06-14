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
     * @throws InvalidAnswerException
     */
    private function __construct(
        public Id $id,
        public Id $questionId,
        public string $answer,
        public int $order,
        public BehaviorEnum $behavior,
        public RestrictionEnum $restrictionEnum,
        public ?Id $questionToAskId,
        public ?array $excludedProductIds
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidAnswerException
     */
    public static function create(
        string $questionId,
        string $answer,
        int $order,
        BehaviorEnum $behavior,
        RestrictionEnum $restrictionEnum,
        ?string $questionToAskId,
        ?array $excludedProductIds
    ): self {
        $id = Id::create();

        try {
            $questionIdVo = Id::restore($questionId);
            $questionToAskIdVo = null;
            if ($questionToAskId) {
                $questionToAskIdVo = Id::restore($questionToAskId);
            }
            $excludedProductIdsVo = null;
            if ($excludedProductIds) {
                foreach ($excludedProductIds as $excludedProductId) {
                    $excludedProductIdsVo[] = Id::restore($excludedProductId);
                }
            }
        } catch (InvalidUuidException $e) {
            $message = "The Answer is not valid: {$e->getMessage()}";
            throw new InvalidAnswerException($message, $e->getCode(), $e);
        }

        return new self(
            id: $id,
            questionId: $questionIdVo,
            answer: $answer,
            order: $order,
            behavior: $behavior,
            restrictionEnum: $restrictionEnum,
            questionToAskId: $questionToAskIdVo,
            excludedProductIds: $excludedProductIdsVo
        );
    }

    /**
     * @throws InvalidAnswerException
     */
    public static function restore(
        string $id,
        string $questionId,
        string $answer,
        int $order,
        BehaviorEnum $behavior,
        RestrictionEnum $restrictionEnum,
        ?string $questionToAskId,
        ?array $excludedProductIds
    ): self {
        try {
            $idVo = Id::restore($id);
            $questionIdVo = Id::restore($questionId);
            $questionToAskIdVo = null;
            if ($questionToAskId) {
                $questionToAskIdVo = Id::restore($questionToAskId);
            }
            $excludedProductIdsVo = null;
            if ($excludedProductIds) {
                foreach ($excludedProductIds as $excludedProductId) {
                    $excludedProductIdsVo[] = Id::restore($excludedProductId);
                }
            }
        } catch (InvalidUuidException $e) {
            $message = "The Answer is not valid: {$e->getMessage()}";
            throw new InvalidAnswerException($message, $e->getCode(), $e);
        }

        return new self(
            id: $idVo,
            questionId: $questionIdVo,
            answer: $answer,
            order: $order,
            behavior: $behavior,
            restrictionEnum: $restrictionEnum,
            questionToAskId: $questionToAskIdVo,
            excludedProductIds: $excludedProductIdsVo
        );
    }

    /**
     * @throws InvalidAnswerException
     */
    public function validate(): void
    {
        Validator::minMax(
            key: 'answer',
            value: $this->answer,
            message: 'The answer must contain between 2 and 255 characters',
            min: 2,
            max: 255
        );

        Validator::positiveNumber(
            key: 'order',
            value: $this->order,
            message: 'The order must be a positive number',
        );

        try {
            Validator::validate('The Answer is not valid');
        } catch (ValidationException $e) {
            throw new InvalidAnswerException("The Answer is not valid", $e->getCode(), $e, $e->getErrors());
        }
    }
}
