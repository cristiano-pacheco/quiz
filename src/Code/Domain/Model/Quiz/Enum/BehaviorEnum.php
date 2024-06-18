<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz\Enum;

enum BehaviorEnum: string
{
    case NONE = 'none';
    case EXCLUDE_ALL_PRODUCTS = 'exclude_all_products';
    case ASK_QUESTION = 'ask_question';
    case RECOMMEND_PRODUCTS = 'recommend_products';
}
