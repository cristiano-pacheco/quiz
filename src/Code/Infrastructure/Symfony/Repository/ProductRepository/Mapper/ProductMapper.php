<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\ProductRepository\Mapper;

use App\Code\Domain\Exception\Quiz\InvalidProductException;
use App\Code\Domain\Model\Catalog\Product;

class ProductMapper
{
    /**
     * @throws InvalidProductException
     */
    public function map(array $data): Product
    {
        return Product::restore(id: $data['id'], name: $data['name']);
    }
}
