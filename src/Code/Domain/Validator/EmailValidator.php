<?php

declare(strict_types=1);

namespace App\Code\Domain\Validator;

class EmailValidator
{
    public static function isValid(mixed $value): bool
    {
        return !(empty($value) || !filter_var($value, FILTER_VALIDATE_EMAIL));
    }
}
