<?php

declare(strict_types=1);

namespace App\Code\Domain\Validator;

class NotEmptyValidator
{
    public static function isValid(mixed $value): bool
    {
        return !empty($value);
    }
}
