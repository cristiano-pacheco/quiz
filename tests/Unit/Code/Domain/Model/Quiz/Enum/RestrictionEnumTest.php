<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Model\Quiz\Enum;

use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use PHPUnit\Framework\TestCase;

final class RestrictionEnumTest extends TestCase
{
    public function testContract(): void
    {
        $this->assertEquals('none', RestrictionEnum::NONE->value);
        $this->assertEquals('exclude_products', RestrictionEnum::EXCLUDE_PRODUCTS->value);
        $this->assertEquals('exclude_all_products', RestrictionEnum::EXCLUDE_ALL_PRODUCTS->value);
    }
}
