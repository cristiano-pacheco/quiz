<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Api\Rest\V1\ProductSuggestion;

use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerIds\Data\InputData;
use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerIds\SuggestProductsByAnswerIdsUseCase;
use App\Code\Infrastructure\Symfony\Serializer\SerializerFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SuggestProductsByAnswerIdsController extends AbstractController
{
    public function __construct(
        private readonly SuggestProductsByAnswerIdsUseCase $suggestProductsByAnswerIdsUseCase,
        private readonly SerializerFactory $serializerFactory
    ) {
    }

    #[Route(
        path: '/api/rest/v1/product-suggestions/by-answer-ids',
        name: 'api.rest.v1.product-suggestions-by-answer-ids',
        methods: [ 'POST' ],
        format: 'json'
    )]
    public function execute(Request $request): JsonResponse
    {
        $input = $this->serializerFactory->create()->deserialize($request->getContent(), InputData::class, 'json');
        $output = $this->suggestProductsByAnswerIdsUseCase->execute($input);
        return $this->json($output);
    }
}
