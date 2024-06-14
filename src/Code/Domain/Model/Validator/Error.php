<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Validator;

readonly class Error
{
    public function __construct(
        public string $key,
        public mixed $value,
        public string $message,
        public ?string $code = null,
    ) {
    }
}
