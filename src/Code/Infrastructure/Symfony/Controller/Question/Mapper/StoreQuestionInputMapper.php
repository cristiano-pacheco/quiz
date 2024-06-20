<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question\Mapper;

use App\Code\Application\UseCase\Question\CreateQuestion\Data\InputData;
use Symfony\Component\HttpFoundation\Request;

class StoreQuestionInputMapper
{
    public function map(Request $request): InputData
    {
        $payload = $request->getPayload()->all();

        return new InputData(
            quizId: $payload['quiz_id'] ?? '',
            question: $payload['question'] ?? '',
            sortOrder: (int)($payload['sort_order'] ?? ''),
        );
    }
}
