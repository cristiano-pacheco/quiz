<?php

declare(strict_types=1);

namespace App\Code\Domain\Validator;

class MinValidator
{
    public static function isValid(string $value, int $min): bool
    {
        return !(!$value || strlen($value) < $min);
    }
}
