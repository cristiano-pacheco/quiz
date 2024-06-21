<?php

declare(strict_types=1);

namespace App\Code\Application\Repository;

use App\Code\Application\Exception\Product\CouldNotFindProductException;
use App\Code\Domain\Model\Catalog\Product;

interface ProductRepositoryInterface
{
    /**
     * @return Product[]
     * @throws CouldNotFindProductException
     */
    public function findAll(): array;

    /**
     * @param string[] $idList
     * @return Product[]
     * @throws CouldNotFindProductException
     * /
     */
    public function findByIdList(array $idList): array;
}
