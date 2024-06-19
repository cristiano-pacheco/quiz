<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz;

use App\Code\Domain\Exception\InvalidUuidException;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Domain\Exception\ValidationException;
use App\Code\Domain\Model\Support\Id;
use App\Code\Domain\Validator\Validator;

readonly class Question
{
    /**
     * @throws InvalidQuestionException
     */
    private function __construct(
        public Id $id,
        public Id $quizId,
        public string $question,
        public int $sortOrder,
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidQuestionException
     */
    public static function create(
        string $quizId,
        string $question,
        int $sortOrder
    ): self {
        $id = Id::create();

        try {
            $quizId = Id::restore($quizId);
        } catch (InvalidUuidException $e) {
            $message = "The Question is not valid: {$e->getMessage()}";
            throw new InvalidQuestionException($message, $e->getCode(), $e);
        }

        return new self(id: $id, quizId: $quizId, question: $question, sortOrder: $sortOrder);
    }

    /**
     * @throws InvalidQuestionException
     */
    public static function restore(
        string $id,
        string $quizId,
        string $question,
        int $sortOrder
    ): self {
        try {
            $idVo = Id::restore($id);
            $quizIdVo = Id::restore($quizId);
        } catch (InvalidUuidException $e) {
            $message = "The Question is not valid: {$e->getMessage()}";
            throw new InvalidQuestionException($message, $e->getCode(), $e);
        }

        return new self(id: $idVo, quizId: $quizIdVo, question: $question, sortOrder: $sortOrder);
    }

    /**
     * @throws InvalidQuestionException
     */
    public function validate(): void
    {
        Validator::minMax(
            key: 'question',
            value: $this->question,
            message: 'The question must contain between 4 and 255 characters',
            min: 4,
            max: 500
        );

        Validator::positiveNumber(
            key: 'sortOrder',
            value: $this->sortOrder,
            message: 'The sort sortOrder must be a positive number',
        );

        try {
            Validator::validate('The Question is not valid');
        } catch (ValidationException $e) {
            throw new InvalidQuestionException("The Question is not valid", $e->getCode(), $e, $e->getErrors());
        }
    }
}
