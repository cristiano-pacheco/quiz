<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Api\Rest\V1\ProductSuggestion;

use App\Code\Application\UseCase\ProductSuggestion\SuggestProductListByAnswerList\SuggestProductListByAnswerListUseCase;
use App\Code\Infrastructure\Symfony\Controller\Api\Rest\V1\ProductSuggestion\Mapper\RequestToInputMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SuggestProductsByAnswerListController extends AbstractController
{
    public function __construct(
        private readonly SuggestProductListByAnswerListUseCase $suggestProductListByAnswerList,
        private readonly RequestToInputMapper $requestToInputMapper
    ) {
    }

    #[Route(
        path: '/api/rest/v1/product-suggestions/by-answer-list',
        name: 'api.rest.v1.product-suggestions-by-answer-list',
        methods: [ 'POST' ],
        format: 'json'
    )]
    public function execute(Request $request): JsonResponse
    {
        $input = $this->requestToInputMapper->map($request);
        $output = $this->suggestProductListByAnswerList->execute($input);
        return $this->json($output);
    }
}
