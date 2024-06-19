<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\Data;

readonly class QuizData
{
    public function __construct(public string $id, public string $name)
    {
    }
}
