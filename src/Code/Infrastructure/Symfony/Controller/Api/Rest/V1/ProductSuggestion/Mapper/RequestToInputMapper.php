<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Api\Rest\V1\ProductSuggestion\Mapper;

use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\Data\InputData;
use App\Code\Infrastructure\Symfony\Serializer\SerializerFactory;
use Symfony\Component\HttpFoundation\Request;

readonly class RequestToInputMapper
{
    public function __construct(
        private SerializerFactory $serializerFactory
    ) {
    }

    public function map(Request $request): InputData
    {
        return $this->serializerFactory->create()->deserialize($request->getContent(), InputData::class, 'json');
    }
}
