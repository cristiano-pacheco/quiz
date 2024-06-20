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
        /** @var string $id */
        $id = $request->get('id', '');

        return new InputData(
            id: $id,
            quizId: $payload['quiz_id'] ?? '',
            question: $payload['question'] ?? '',
            sortOrder: (int)($payload['sort_order'] ?? ''),
        );
    }
}
