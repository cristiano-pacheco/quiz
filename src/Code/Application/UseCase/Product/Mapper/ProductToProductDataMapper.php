<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Product\Mapper;

use App\Code\Application\UseCase\Product\Data\ProductData;
use App\Code\Domain\Model\Catalog\Product;

class ProductToProductDataMapper
{
    public function map(Product $product): ProductData
    {
        return new ProductData(id: $product->id->value->toString(), name: $product->name);
    }
}
