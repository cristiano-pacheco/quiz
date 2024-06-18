<?php

declare(strict_types=1);

namespace App\Code\Domain\Service\ProductRecommendation\Registry;

use App\Code\Domain\Model\Support\Id;

class ProductRegistry
{
    /**
     * @param Id[] $productIds
     */
    public function __construct(private array $productIds = [])
    {
    }

    public function get(Id $productId) : ?Id
    {
        $productIdString = $productId->value->toString();
        return $this->productIds[$productIdString] ?? null;
    }

    public function add(Id $productId): void
    {
        $productIdString = $productId->value->toString();
        if (array_key_exists($productIdString, $this->productIds)) {
            return;
        }

        $this->productIds[$productIdString] = $productId;
    }

    public function remove(Id $productId): void
    {
        $productIdString = $productId->value->toString();
        if (!array_key_exists($productIdString, $this->productIds)) {
            return;
        }

        unset($this->productIds[$productIdString]);
    }

    /**
     * @return Id[]
     */
    public function productIds(): array
    {
        return $this->productIds;
    }

    public function reset(): void
    {
        $this->productIds = [];
    }
}
