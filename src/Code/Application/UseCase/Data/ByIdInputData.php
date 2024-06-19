<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Data;

readonly class ByIdInputData
{
    public function __construct(public string $id)
    {
    }
}
