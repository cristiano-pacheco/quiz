<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\ProductRepository;

use App\Code\Application\Exception\Product\CouldNotFindProductException;
use App\Code\Application\Repository\ProductRepositoryInterface;
use App\Code\Domain\Model\Catalog\Product;
use App\Code\Infrastructure\Symfony\Repository\ProductRepository\Query\FindAllQuery;
use App\Code\Infrastructure\Symfony\Repository\ProductRepository\Query\FindProductListByIdListQuery;
use Exception;

readonly class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private FindAllQuery $findAllQuery,
        private FindProductListByIdListQuery $findProductListByIdListQuery
    ) {
    }

    /**
     * @return Product[]
     * @throws CouldNotFindProductException
     */
    public function findAll(): array
    {
        try {
            return $this->findAllQuery->execute();
        } catch (Exception $e) {
            $message = "Could not find the product list | reason: {$e->getMessage()}";
            throw new CouldNotFindProductException($message, $e->getCode(), $e);
        }
    }

    public function findByIdList(array $idList): array
    {
        try {
            return $this->findProductListByIdListQuery->execute($idList);
        } catch (Exception $e) {
            $message = "Could not find the product list | reason: {$e->getMessage()}";
            throw new CouldNotFindProductException($message, $e->getCode(), $e);
        }
    }
}
