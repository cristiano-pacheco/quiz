<?php

declare(strict_types=1);

namespace App\Code\Domain\Service\ProductRecommendation\Data;

use App\Code\Domain\Model\Support\Id;

readonly class Output
{
    /**
     * @param Id[] $productIds
     */
    public function __construct(public array $productIds = [])
    {
    }
}
