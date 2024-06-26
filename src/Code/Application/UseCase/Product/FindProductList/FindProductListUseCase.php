<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Product\FindProductList;

use App\Code\Application\Exception\Product\CouldNotFindProductException;
use App\Code\Application\Repository\ProductRepositoryInterface;
use App\Code\Application\UseCase\Product\Data\OutputData;
use App\Code\Application\UseCase\Product\Mapper\ProductToOutputDataMapper;

readonly class FindProductListUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductToOutputDataMapper $productToOutputDataMapper
    ) {
    }

    /**
     * @throws CouldNotFindProductException
     */
    public function execute(): OutputData
    {
        $quizList = $this->productRepository->findAll();
        return $this->productToOutputDataMapper->map($quizList);
    }
}
