<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\CreateQuiz\Data;

readonly class InputData
{
    public function __construct(public string $name)
    {
    }
}
