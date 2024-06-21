<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Product\FindProductListByIdList;

use App\Code\Application\Exception\Product\CouldNotFindProductException;
use App\Code\Application\Repository\ProductRepositoryInterface;
use App\Code\Application\UseCase\Product\Data\OutputData;
use App\Code\Application\UseCase\Product\Mapper\ProductToOutputDataMapper;

readonly class FindProductListByIdListUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductToOutputDataMapper $productToOutputDataMapper
    ) {
    }

    /**
     * @param string[] $productIdList
     * @throws CouldNotFindProductException
     */
    public function execute(array $productIdList): OutputData
    {
        $quizList = $this->productRepository->findByIdList($productIdList);
        return $this->productToOutputDataMapper->map($quizList);
    }
}
