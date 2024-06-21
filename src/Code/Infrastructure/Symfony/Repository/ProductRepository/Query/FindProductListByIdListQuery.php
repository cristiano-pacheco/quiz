<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\ProductRepository\Query;

use App\Code\Domain\Exception\Quiz\InvalidProductException;
use App\Code\Domain\Model\Catalog\Product;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\ProductRepository\Mapper\ProductMapper;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindProductListByIdListQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private ProductMapper $productMapper
    ) {
    }

    /**
     * @param string[] $productIdList
     * @return Product[]
     * @throws DatabaseException
     * @throws InvalidProductException
     */
    public function execute(array $productIdList): array
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('product');
        $query->where(
            $query->expr()->in('id', ':product_id_list')
        );
        $query->setParameter('product_id_list', $productIdList, ArrayParameterType::STRING);

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
