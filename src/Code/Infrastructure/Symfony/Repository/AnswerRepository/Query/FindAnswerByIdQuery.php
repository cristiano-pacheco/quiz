<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Query;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Exception\Quiz\InvalidBehaviorEnumValueException;
use App\Code\Domain\Exception\Quiz\InvalidRestrictionEnumValueException;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Mapper\AnswerMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindAnswerByIdQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private AnswerMapper $answerMapper
    ) {
    }

    /**
     * @throws CouldNotFindAnswerException
     * @throws DatabaseException
     * @throws InvalidAnswerException
     * @throws InvalidBehaviorEnumValueException
     * @throws InvalidRestrictionEnumValueException
     */
    public function execute(string $id): Answer
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('answer');
        $query->where('id = :id');
        $query->setParameter('id', $id);

        try {
            $result = $query->executeQuery()->fetchAssociative();
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        if ($result === false) {
            throw new CouldNotFindAnswerException("Could not find the Answer with id: $id");
        }

        return $this->answerMapper->map($result);
    }
}
