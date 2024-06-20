<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\ProductRepository\Query;

use App\Code\Domain\Exception\Quiz\InvalidProductException;
use App\Code\Domain\Model\Catalog\Product;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\ProductRepository\Mapper\ProductMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindAllQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private ProductMapper $productMapper
    ) {
    }

    /**
     * @return Product[]
     * @throws DatabaseException
     * @throws InvalidProductException
     */
    public function execute(): array
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('product');

        try {
            $result = $query->executeQuery()->fetchAllAssociative();
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        $productList = [];
        foreach ($result as $product) {
            $productList[] = $this->productMapper->map($product);
        }

        return $productList;
    }
}
