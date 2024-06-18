<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuizRepository;

use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Domain\Model\Quiz\Quiz;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command\CreateQuizCommand;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command\DeleteQuizCommand;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command\UpdateQuizCommand;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Query\FindAllQuery;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Query\FindQuizByIdQuery;

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
        $this->createQuizCommand->execute($quiz);
    }

    public function findById(string $id): Quiz
    {
        return $this->findQuizByIdQuery->execute($id);
    }

    public function findAll(): array
    {
        return $this->findAllQuery->execute();
    }

    public function update(Quiz $quiz): void
    {
        $this->updateQuizCommand->execute($quiz);
    }

    public function delete(Quiz $quiz): void
    {
        $this->deleteQuizCommand->execute($quiz);
    }
}
