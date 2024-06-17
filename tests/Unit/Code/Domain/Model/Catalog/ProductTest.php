<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Model\Catalog;

use App\Code\Domain\Exception\Quiz\InvalidProductException;
use App\Code\Domain\Model\Catalog\Product;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testCreateProduct(): void
    {
        $productName = 'Product Name';
        $product = Product::create($productName);
        $this->assertSame($productName, $product->name);
        $this->assertSame(36, strlen($product->id->value->toString()));
    }

    public function testRestoreProduct(): void
    {
        $productName = 'Product Name';
        $id = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $product = Product::restore($id, $productName);
        $this->assertSame($productName, $product->name);
        $this->assertSame($id, $product->id->value->toString());
    }

    public function testInvalidName(): void
    {
        $exception = InvalidProductException::class;
        $this->expectException($exception);
        Product::create('P');

        $this->expectException($exception);
        Product::restore('d1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b', 'P');
    }

    public function testInvalidId(): void
    {
        $exception = InvalidProductException::class;
        $this->expectException($exception);
        Product::restore('d1b3b3b3', 'P');
    }
}
