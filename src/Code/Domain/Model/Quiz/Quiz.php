<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz;

use App\Code\Domain\Exception\InvalidUuidException;
use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use App\Code\Domain\Exception\ValidationException;
use App\Code\Domain\Model\Support\Id;
use App\Code\Domain\Validator\Validator;

readonly class Quiz
{
    /**
     * @throws InvalidQuizException
     */
    private function __construct(public Id $id, public string $name)
    {
        $this->validate();
    }

    /**
     * @throws InvalidQuizException
     */
    public static function create(string $name): self
    {
        $id = Id::create();
        return new self(id: $id, name: $name);
    }

    /**
     * @throws InvalidQuizException
     */
    public static function restore(string $id, string $name): self
    {
        try {
            $idVo = Id::restore($id);
        } catch (InvalidUuidException $e) {
            $message = "The Quiz is not valid: {$e->getMessage()}";
            throw new InvalidQuizException($message, $e->getCode(), $e);
        }

        return new self(id: $idVo, name: $name);
    }

    /**
     * @throws InvalidQuizException
     */
    public function validate(): void
    {
        Validator::minMax(
            key: 'name',
            value: $this->name,
            message: 'The name must contain between 4 and 255 characters',
            min: 4,
            max: 255
        );

        try {
            Validator::validate();
        } catch (ValidationException $e) {
            throw new InvalidQuizException('The Quiz is not valid', $e->getCode(), $e, $e->getErrors());
        }
    }
}
