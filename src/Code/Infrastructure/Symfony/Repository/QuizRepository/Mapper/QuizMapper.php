<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuizRepository\Mapper;

use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use App\Code\Domain\Model\Quiz\Quiz;

class QuizMapper
{
    /**
     * @throws InvalidQuizException
     */
    public function map(array $data): Quiz
    {
        return Quiz::restore(id: $data['id'], name: $data['name']);
    }
}
