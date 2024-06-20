<?php

declare(strict_types=1);

namespace App\Code\Application\Repository;

use App\Code\Application\Exception\Answer\CouldNotCreateAnswerException;
use App\Code\Application\Exception\Answer\CouldNotDeleteAnswerException;
use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Exception\Answer\CouldNotUpdateAnswerException;
use App\Code\Domain\Model\Quiz\Answer;

interface AnswerRepositoryInterface
{
    /**
     * @throws CouldNotCreateAnswerException
     */
    public function create(Answer $answer): void;

    /**
     * @throws CouldNotFindAnswerException
     */
    public function findById(string $id): Answer;

    /**
     * @return Answer[]
     * @throws CouldNotFindAnswerException
     */
    public function findAnswerListByQuestionId(string $questionId): array;

    /**
     * @throws CouldNotUpdateAnswerException
     */
    public function update(Answer $answer): void;

    /**
     * @throws CouldNotDeleteAnswerException
     */
    public function delete(Answer $answer): void;

    /**
     * @param string[] $questionIdList
     * @return Answer[]
     * @throws CouldNotFindAnswerException
     */
    public function findAnswerListByQuestionIdList(array $questionIdList): array;
}
