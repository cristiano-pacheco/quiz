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
        public int $order,
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidQuestionException
     */
    public static function create(
        string $quizId,
        string $question,
        int $order
    ): self {
        $id = Id::create();

        try {
            $quizId = Id::restore($quizId);
        } catch (InvalidUuidException $e) {
            $message = "The Question is not valid: {$e->getMessage()}";
            throw new InvalidQuestionException($message, $e->getCode(), $e);
        }

        return new self(id: $id, quizId: $quizId, question: $question, order: $order);
    }

    /**
     * @throws InvalidQuestionException
     */
    public static function restore(
        string $id,
        string $quizId,
        string $question,
        int $order
    ): self {
        try {
            $idVo = Id::restore($id);
            $quizIdVo = Id::restore($quizId);
        } catch (InvalidUuidException $e) {
            $message = "The Question is not valid: {$e->getMessage()}";
            throw new InvalidQuestionException($message, $e->getCode(), $e);
        }

        return new self(id: $idVo, quizId: $quizIdVo, question: $question, order: $order);
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
            min: 10,
            max: 500
        );

        Validator::positiveNumber(
            key: 'order',
            value: $this->order,
            message: 'The order must be a positive number',
        );

        try {
            Validator::validate('The Question is not valid');
        } catch (ValidationException $e) {
            throw new InvalidQuestionException("The Question is not valid", $e->getCode(), $e, $e->getErrors());
        }
    }
}
