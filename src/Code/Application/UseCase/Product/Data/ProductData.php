<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Product\Data;

readonly class ProductData
{
    public function __construct(public string $id, public string $name)
    {
    }
}
