<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Model\Quiz\Enum;

use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use PHPUnit\Framework\TestCase;

final class BehaviorEnumTest extends TestCase
{
    public function testContract(): void
    {
        $this->assertEquals('none', BehaviorEnum::NONE->value);
        $this->assertEquals('exclude_products', BehaviorEnum::EXCLUDE_PRODUCTS->value);
        $this->assertEquals('ask_question', BehaviorEnum::ASK_QUESTION->value);
        $this->assertEquals('recommend_products', BehaviorEnum::RECOMMEND_PRODUCTS->value);
    }
}
