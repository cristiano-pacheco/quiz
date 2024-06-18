<?php

declare(strict_types=1);

namespace App\Code\Domain\Service\ProductRecommendation\Data;

use App\Code\Domain\Model\Quiz\Answer;

readonly class Input
{
    /**
     * @param Answer[] $answers
     */
    public function __construct(public array $answers)
    {
    }
}
