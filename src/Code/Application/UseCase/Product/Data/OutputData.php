<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Product\Data;


readonly class OutputData
{
    /**
     * @param ProductData[] $productList
     */
    public function __construct(public array $productList)
    {
    }
}
