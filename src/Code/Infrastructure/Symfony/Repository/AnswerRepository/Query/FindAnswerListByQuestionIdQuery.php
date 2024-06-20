<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Query;

use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Exception\Quiz\InvalidBehaviorEnumValueException;
use App\Code\Domain\Exception\Quiz\InvalidRestrictionEnumValueException;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Mapper\AnswerMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindAnswerListByQuestionIdQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private AnswerMapper $answerMapper
    ) {
    }

    /**
     * @return Answer[]
     * @throws DatabaseException
     * @throws InvalidAnswerException
     * @throws InvalidBehaviorEnumValueException
     * @throws InvalidRestrictionEnumValueException
     */
    public function execute(string $questionId): array
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('answer');
        $query->where('question_id = :question_id');
        $query->setParameter('question_id', $questionId);

        try {
            $result = $query->executeQuery()->fetchAllAssociative();
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        $answerList = [];
        foreach ($result as $answer) {
            $answerList[] = $this->answerMapper->map($answer);
        }

        return $answerList;
    }
}
