<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Service\ProductRecommendation\Registry;

use App\Code\Domain\Model\Support\Id;
use App\Code\Domain\Service\ProductRecommendation\Registry\ProductRegistry;
use PHPUnit\Framework\TestCase;

final class ProductRegistryTest extends TestCase
{
    private ProductRegistry $sut;

    protected function setUp(): void
    {
        $this->sut = new ProductRegistry();
    }

    public function testRegistry(): void
    {
        $idOne = Id::Create();
        $idTwo = Id::Create();

        $this->sut->add($idOne);
        $this->sut->add($idTwo);

        $this->assertCount(2, $this->sut->productIds());

        $this->sut->remove($idOne);
        $this->assertCount(1, $this->sut->productIds());

        $this->assertNull($this->sut->get($idOne));

        $this->assertSame($idTwo, $this->sut->get($idTwo));

        $this->sut->reset();

        $this->assertCount(0, $this->sut->productIds());
    }
}
