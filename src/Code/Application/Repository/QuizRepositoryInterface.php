<?php

declare(strict_types=1);

namespace App\Code\Application\Repository;

use App\Code\Application\Exception\Quiz\CouldNotCreateQuizException;
use App\Code\Application\Exception\Quiz\CouldNotDeleteQuizException;
use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Exception\Quiz\CouldNotUpdateQuizException;
use App\Code\Application\Exception\Quiz\QuizNotFoundException;
use App\Code\Domain\Model\Quiz\Quiz;

interface QuizRepositoryInterface
{
    /**
     * @throws CouldNotCreateQuizException
     */
    public function create(Quiz $quiz): void;

    /**
     * @throws CouldNotFindQuizException
     */
    public function findById(string $id): Quiz;

    /**
     * @return Quiz[]
     * @throws CouldNotFindQuizException
     */
    public function findAll(): array;

    /**
     * @throws CouldNotUpdateQuizException
     */
    public function update(Quiz $quiz): void;

    /**
     * @throws CouldNotDeleteQuizException
     */
    public function delete(Quiz $quiz): void;
}
