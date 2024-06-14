<?php

declare(strict_types=1);

namespace App\Code\Domain\Model\Catalog;

use App\Code\Domain\Exception\InvalidUuidException;
use App\Code\Domain\Exception\Quiz\InvalidProductException;
use App\Code\Domain\Exception\ValidationException;
use App\Code\Domain\Model\Support\Id;
use App\Code\Domain\Validator\Validator;

class Product
{
    /**
     * @throws InvalidProductException
     */
    private function __construct(public Id $id, public string $name)
    {
        $this->validate();
    }

    /**
     * @throws InvalidProductException
     */
    public static function create(string $name): self
    {
        $id = Id::create();
        return new self(id: $id, name: $name);
    }

    /**
     * @throws InvalidProductException
     */
    public static function restore(string $id, string $name): self
    {
        try {
            $idVo = Id::restore($id);
        } catch (InvalidUuidException $e) {
            $message = "The Product is not valid: {$e->getMessage()}";
            throw new InvalidProductException($message, $e->getCode(), $e);
        }

        return new self(id: $idVo, name: $name);
    }

    /**
     * @throws InvalidProductException
     */
    public function validate(): void
    {
        Validator::minMax(
            key: 'name',
            value: $this->name,
            message: 'The name must contain between 2 and 255 characters',
            min: 2,
            max: 255
        );

        try {
            Validator::validate();
        } catch (ValidationException $e) {
            throw new InvalidProductException('The Product is not valid', $e->getCode(), $e, $e->getErrors());
        }
    }
}
