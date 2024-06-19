<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\UpdateQuiz\Data;

readonly class InputData
{
    public function __construct(public string $id, public string $name)
    {
    }
}
