<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Mapper;

use Symfony\Component\Serializer\SerializerInterface;

readonly class ArrayToJsonMapper
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function map(array $data): string
    {
        return $this->serializer->serialize($data, 'json');
    }
}
