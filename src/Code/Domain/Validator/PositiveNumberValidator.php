<?php

declare(strict_types=1);

namespace App\Code\Domain\Validator;

class PositiveNumberValidator
{
    public static function isValid(int $value): bool
    {
        return $value >= 0;
    }
}
