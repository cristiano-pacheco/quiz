<?php

declare(strict_types=1);

namespace App\Code\Domain\Exception;

use App\Code\Domain\Model\Validator\Error;
use Exception;
use Throwable;

class DomainException extends Exception
{
    /**
     * @param Error[] $errors
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
        private readonly array $errors = []
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
