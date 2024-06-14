<?php

declare(strict_types=1);

namespace App\Code\Domain\Validator;

class MinMaxValidator
{
    public static function isValid(string $value, int $min = 2, int $max = 255): bool
    {
        return !(!$value || strlen($value) < $min || strlen($value) > $max);
    }
}
