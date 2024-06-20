<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question\Mapper;

use App\Code\Application\UseCase\Question\UpdateQuestion\Data\InputData;
use Symfony\Component\HttpFoundation\Request;

class UpdateQuestionInputMapper
{
    public function map(Request $request): InputData
    {
        $payload = $request->getPayload()->all();

        return new InputData(
            id: $payload['id'] ?? '',
            quizId: $payload['quiz_id'] ?? '',
            question: $payload['question'] ?? '',
            sortOrder: (int)($payload['sort_order'] ?? ''),
        );
    }
}
