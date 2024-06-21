<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository;

use App\Code\Application\Exception\Answer\CouldNotCreateAnswerException;
use App\Code\Application\Exception\Answer\CouldNotDeleteAnswerException;
use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Exception\Answer\CouldNotUpdateAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Command\CreateAnswerCommand;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Command\DeleteAnswerCommand;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Command\UpdateAnswerCommand;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Query\FindAnswerByIdQuery;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Query\FindAnswerListByAnswerIdListQuery;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Query\FindAnswerListByQuestionIdListQuery;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Query\FindAnswerListByQuestionIdQuery;
use Exception;

readonly class AnswerRepository implements AnswerRepositoryInterface
{
    public function __construct(
        private CreateAnswerCommand $createAnswerCommand,
        private UpdateAnswerCommand $updateAnswerCommand,
        private DeleteAnswerCommand $deleteAnswerCommand,
        private FindAnswerByIdQuery $findAnswerByIdQuery,
        private FindAnswerListByQuestionIdQuery $findAnswerListByQuestionIdIdQuery,
        private FindAnswerListByQuestionIdListQuery $findAnswerListByQuestionIdListQuery,
        private FindAnswerListByAnswerIdListQuery $findAnswerListByAnswerIdListQuery
    ) {
    }

    public function create(Answer $answer): void
    {
        try {
            $this->createAnswerCommand->execute($answer);
        } catch (Exception $e) {
            throw new CouldNotCreateAnswerException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function findById(string $id): Answer
    {
        try {
            return $this->findAnswerByIdQuery->execute($id);
        } catch (Exception $e) {
            $message = "Could not find the Answer with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotFindAnswerException($message, $e->getCode(), $e);
        }
    }

    public function findAnswerListByQuestionId(string $questionId): array
    {
        try {
            return $this->findAnswerListByQuestionIdIdQuery->execute($questionId);
        } catch (Exception $e) {
            $message = "Could not find the Answer list | reason: {$e->getMessage()}";
            throw new CouldNotFindAnswerException($message, $e->getCode(), $e);
        }
    }

    public function update(Answer $answer): void
    {
        try {
            $this->updateAnswerCommand->execute($answer);
        } catch (Exception $e) {
            $id = $answer->id->value->toString();
            $message = "Could not update the Answer with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotUpdateAnswerException($message, $e->getCode(), $e);
        }
    }

    public function delete(Answer $answer): void
    {
        try {
            $this->deleteAnswerCommand->execute($answer);
        } catch (Exception $e) {
            $id = $answer->id->value->toString();
            $message = "Could not delete the Answer with id: $id | reason: {$e->getMessage()}";
            throw new CouldNotDeleteAnswerException($message, $e->getCode(), $e);
        }
    }

    public function findAnswerListByQuestionIdList(array $questionIdList): array
    {
        try {
            return $this->findAnswerListByQuestionIdListQuery->execute($questionIdList);
        } catch (Exception $e) {
            $message = "Could not find the Answer list | reason: {$e->getMessage()}";
            throw new CouldNotFindAnswerException($message, $e->getCode(), $e);
        }
    }


    public function findAnswerListByAnswerIdList(array $answerIdList): array
    {
        try {
            return $this->findAnswerListByAnswerIdListQuery->execute($answerIdList);
        } catch (Exception $e) {
            $message = "Could not find the Answer list | reason: {$e->getMessage()}";
            throw new CouldNotFindAnswerException($message, $e->getCode(), $e);
        }
    }
}
