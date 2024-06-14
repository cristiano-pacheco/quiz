<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Support;

use App\Code\Domain\Exception\InvalidUuidException;
use Symfony\Component\Uid\Uuid;

readonly class Id
{
    private function __construct(public Uuid $value)
    {
    }

    public static function create(): self
    {
        $value = Uuid::v4();
        return new self(value: $value);
    }

    /**
     * @throws InvalidUuidException
     */
    public static function restore(string $value): self
    {
        if (!Uuid::isValid($value)) {
            $message = "The uuid $value is not valid.";
            throw new InvalidUuidException($message);
        }

        $value = Uuid::fromString($value);

        return new self(value: $value);
    }
}
