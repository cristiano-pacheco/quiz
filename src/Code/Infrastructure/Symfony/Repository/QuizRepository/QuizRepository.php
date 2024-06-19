<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuizRepository;

use App\Code\Application\Exception\Quiz\CouldNotCreateQuizException;
use App\Code\Application\Exception\Quiz\CouldNotDeleteQuizException;
use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Exception\Quiz\CouldNotUpdateQuizException;
use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Domain\Model\Quiz\Quiz;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command\CreateQuizCommand;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command\DeleteQuizCommand;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command\UpdateQuizCommand;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Query\FindAllQuery;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Query\FindQuizByIdQuery;
use Exception;

readonly class QuizRepository implements QuizRepositoryInterface
{
    public function __construct(
        private CreateQuizCommand $createQuizCommand,
        private UpdateQuizCommand $updateQuizCommand,
        private DeleteQuizCommand $deleteQuizCommand,
        private FindQuizByIdQuery $findQuizByIdQuery,
        private FindAllQuery $findAllQuery,
    ) {
    }

    public function create(Quiz $quiz): void
    {
        try {
            $this->createQuizCommand->execute($quiz);
        } catch (Exception $e) {
            throw new CouldNotCreateQuizException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function findById(string $id): Quiz
    {
        try {
            return $this->findQuizByIdQuery->execute($id);
        } catch (Exception $e) {
            $message = "Could not find the quiz with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotFindQuizException($message, $e->getCode(), $e);
        }
    }

    public function findAll(): array
    {
        try {
            return $this->findAllQuery->execute();
        } catch (Exception $e) {
            $message = "Could not find the quiz list | reason: {$e->getMessage()}";
            throw new CouldNotFindQuizException($message, $e->getCode(), $e);
        }
    }

    public function update(Quiz $quiz): void
    {
        try {
            $this->updateQuizCommand->execute($quiz);
        } catch (Exception $e) {
            $id = $quiz->id->value->toString();
            $message = "Could not update the quiz with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotUpdateQuizException($message, $e->getCode(), $e);
        }
    }

    public function delete(Quiz $quiz): void
    {
        try {
            $this->deleteQuizCommand->execute($quiz);
        } catch (Exception $e) {
            $id = $quiz->id->value->toString();
            $message = "Could not delete the quiz with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotDeleteQuizException($message, $e->getCode(), $e);
        }
    }
}
