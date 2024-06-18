<?php

declare(strict_types=1);

namespace App\Code\Application\Repository;

use App\Code\Application\Exception\QuizNotFoundException;
use App\Code\Domain\Model\Quiz\Quiz;

interface QuizRepositoryInterface
{
    public function create(Quiz $quiz): void;

    /**
     * @throws QuizNotFoundException
     */
    public function findById(string $id): Quiz;

    /**
     * @return Quiz[]
     */
    public function findAll(): array;
    public function update(Quiz $quiz): void;
    public function delete(Quiz $quiz): void;
}
