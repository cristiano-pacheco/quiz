<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz\Enum;

use App\Code\Domain\Exception\Quiz\InvalidBehaviorEnumValueException;
use App\Code\Domain\Model\Validator\Error;

enum BehaviorEnum: string
{
    case NONE = 'none';
    case EXCLUDE_ALL_PRODUCTS = 'exclude_all_products';
    case ASK_QUESTION = 'ask_question';
    case RECOMMEND_PRODUCTS = 'recommend_products';

    /**
     * @throws InvalidBehaviorEnumValueException
     */
    public static function fromString(string $value): self
    {
        $enumValue = self::tryFrom($value);

        if ($enumValue === null) {
            $message = "Invalid behavior enum value: $value";
            $error = new Error(key: 'Behavior', value: $value, message: $message);
            throw new InvalidBehaviorEnumValueException($message, 0, null, [ $error ]);
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
                'value' => self::ASK_QUESTION->value,
                'label' => 'Ask question',
            ],
            [
                'value' => self::RECOMMEND_PRODUCTS->value,
                'label' => 'Recommend products',
            ],
        ];
    }
}
