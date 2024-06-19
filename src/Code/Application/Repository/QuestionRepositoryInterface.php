<?php

declare(strict_types=1);

namespace App\Code\Application\Repository;

use App\Code\Application\Exception\Question\CouldNotCreateQuestionException;
use App\Code\Application\Exception\Question\CouldNotDeleteQuestionException;
use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Exception\Question\CouldNotUpdateQuestionException;
use App\Code\Domain\Model\Quiz\Question;

interface QuestionRepositoryInterface
{
    /**
     * @throws CouldNotCreateQuestionException
     */
    public function create(Question $question): void;

    /**
     * @throws CouldNotFindQuestionException
     */
    public function findById(string $id): Question;

    /**
     * @return Question[]
     * @throws CouldNotFindQuestionException
     */
    public function findQuestionListByQuizId(string $quizId): array;

    /**
     * @throws CouldNotUpdateQuestionException
     */
    public function update(Question $question): void;

    /**
     * @throws CouldNotDeleteQuestionException
     */
    public function delete(Question $question): void;
}
