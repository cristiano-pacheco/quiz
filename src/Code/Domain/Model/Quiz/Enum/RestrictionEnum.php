<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz\Enum;

use App\Code\Domain\Exception\Quiz\InvalidRestrictionEnumValueException;
use App\Code\Domain\Model\Validator\Error;

enum RestrictionEnum: string
{
    case NONE = 'none';
    case EXCLUDE_ALL_PRODUCTS = 'exclude_all_products';
    case EXCLUDE_PRODUCTS = 'exclude_products';

    /**
     * @throws InvalidRestrictionEnumValueException
     */
    public static function fromString(string $value): self
    {
        $enumValue = self::tryFrom($value);

        if ($enumValue === null) {
            $message = "Invalid restriction enum value: $value";
            $error = new Error(key: 'Restriction', value: $value, message: $message);
            throw new InvalidRestrictionEnumValueException($message, 0, null, [ $error ]);
        }

        return $enumValue;
    }

    public static function toArray(): array
    {
        return [
            [
                'value' => self::NONE->value,
                'label' => 'None',
            ],
            [
                'value' => self::EXCLUDE_ALL_PRODUCTS->value,
                'label' => 'Exclude all products',
            ],
            [
                'value' => self::EXCLUDE_PRODUCTS->value,
                'label' => 'Exclude products',
            ],
        ];
    }
}
