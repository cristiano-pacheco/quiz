<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Serializer;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    public function create(): Serializer
    {
        $encoders = [
            new JsonEncoder(),
        ];

        $extractor = new PropertyInfoExtractor([], [ new PhpDocExtractor(), new ReflectionExtractor() ]);
        $normalizers = [
            new JsonSerializableNormalizer(),
            new ObjectNormalizer(propertyTypeExtractor: $extractor),
            new ArrayDenormalizer(),
        ];

        return new Serializer($normalizers, $encoders);
    }
}
