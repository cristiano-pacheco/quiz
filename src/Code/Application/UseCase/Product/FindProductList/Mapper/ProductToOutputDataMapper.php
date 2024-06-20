<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Product\FindProductList\Mapper;

use App\Code\Application\UseCase\Product\FindProductList\Data\OutputData;
use App\Code\Application\UseCase\Product\Mapper\ProductToProductDataMapper;
use App\Code\Domain\Model\Catalog\Product;

readonly class ProductToOutputDataMapper
{
    public function __construct(public ProductToProductDataMapper $productToProductDataMapper)
    {
    }

    /**
     * @param Product[] $productListModel
     */
    public function map(array $productListModel): OutputData
    {
        $productList = [];
        foreach ($productListModel as $product) {
            if (!$product instanceof Product) {
                throw new \InvalidArgumentException('Invalid product list');
            }
            $product = $this->productToProductDataMapper->map($product);
            $productList[$product->id] = $product;
        }
        return new OutputData(productList: $productList);
    }
}
