<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Product\FindProductList\Data;

use App\Code\Application\UseCase\Product\Data\ProductData;

readonly class OutputData
{
    /**
     * @param ProductData[] $productList
     */
    public function __construct(public array $productList)
    {
    }
}
