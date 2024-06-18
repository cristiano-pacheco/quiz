<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz\Enum;

enum BehaviorEnum: string
{
    case NONE = 'none';
    case EXCLUDE_PRODUCTS = 'exclude_products';
    case ASK_QUESTION = 'ask_question';
    case ADD_PRODUCTS = 'add_products';
}
