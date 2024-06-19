<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuestionRepository;

use App\Code\Application\Exception\Question\CouldNotCreateQuestionException;
use App\Code\Application\Exception\Question\CouldNotDeleteQuestionException;
use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Exception\Question\CouldNotUpdateQuestionException;
use App\Code\Application\Repository\QuestionRepositoryInterface;
use App\Code\Domain\Model\Quiz\Question;
use App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Command\CreateQuestionCommand;
use App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Command\DeleteQuestionCommand;
use App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Command\UpdateQuestionCommand;
use App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Query\FindQuestionByIdQuery;
use App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Query\FindQuestionListByQuizIdQuery;
use Exception;

readonly class QuestionRepository implements QuestionRepositoryInterface
{
    public function __construct(
        private CreateQuestionCommand $createQuestionCommand,
        private UpdateQuestionCommand $updateQuestionCommand,
        private DeleteQuestionCommand $deleteQuestionCommand,
        private FindQuestionByIdQuery $findQuestionByIdQuery,
        private FindQuestionListByQuizIdQuery $findQuestionListByQuizIdQuery,
    ) {
    }

    public function create(Question $question): void
    {
        try {
            $this->createQuestionCommand->execute($question);
        } catch (Exception $e) {
            throw new CouldNotCreateQuestionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function findById(string $id): Question
    {
        try {
            return $this->findQuestionByIdQuery->execute($id);
        } catch (Exception $e) {
            $message = "Could not find the Question with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotFindQuestionException($message, $e->getCode(), $e);
        }
    }

    public function findQuestionListByQuizId(string $quizId): array
    {
        try {
            return $this->findQuestionListByQuizIdQuery->execute($quizId);
        } catch (Exception $e) {
            $message = "Could not find the Question list | reason: {$e->getMessage()}";
            throw new CouldNotFindQuestionException($message, $e->getCode(), $e);
        }
    }

    public function update(Question $question): void
    {
        try {
            $this->updateQuestionCommand->execute($question);
        } catch (Exception $e) {
            $id = $question->id->value->toString();
            $message = "Could not update the Question with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotUpdateQuestionException($message, $e->getCode(), $e);
        }
    }

    public function delete(Question $question): void
    {
        try {
            $this->deleteQuestionCommand->execute($question);
        } catch (Exception $e) {
            $id = $question->id->value->toString();
            $message = "Could not delete the Question with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotDeleteQuestionException($message, $e->getCode(), $e);
        }
    }
}
