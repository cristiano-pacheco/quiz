<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Quiz\Enum;

enum RestrictionEnum: string
{
    case NONE = 'none';
    case EXCLUDE_ALL_PRODUCTS = 'exclude_all_products';
    case EXCLUDE_PRODUCTS = 'exclude_products';
}
