<?php

declare(strict_types=1);

namespace App\Code\Domain\Validator;

use App\Code\Domain\Exception\ValidationException;
use App\Code\Domain\Model\Validator\Error;

class Validator
{
    private static array $errors = [];

    public static function notEmpty(string $key, mixed $value, string $message): void
    {
        if (NotEmptyValidator::isValid(value: $value)) {
            return;
        }

        self::$errors[] = new Error(key: $key, value: $value, message: $message);
    }

    public static function minMax(string $key, string $value, string $message, int $min, int $max): void
    {
        if (MinMaxValidator::isValid(value: $value, min: $min, max: $max)) {
            return;
        }

        self::$errors[] = new Error(key: $key, value: $value, message: $message);
    }

    public static function min(string $key, string $value, string $message, int $min): void
    {
        if (MinValidator::isValid(value: $value, min: $min)) {
            return;
        }

        self::$errors[] = new Error(key: $key, value: $value, message: $message);
    }

    public static function positiveNumber(string $key, int $value, string $message): void
    {
        if (PositiveNumberValidator::isValid(value: $value)) {
            return;
        }

        self::$errors[] = new Error(key: $key, value: $value, message: $message);
    }

    public static function email(string $key, mixed $value, string $message): void
    {
        if (EmailValidator::isValid(value: $value)) {
            return;
        }

        self::$errors[] = new Error(key: $key, value: $value, message: $message);
    }

    /**
     * @throws ValidationException
     */
    public static function validate(string $message = 'Validation error'): void
    {
        $errors = self::$errors;
        self::$errors = [];
        if ($errors) {
            throw new ValidationException(message: $message, errors: $errors);
        }
    }
}
