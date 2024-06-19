<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Query;

use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Domain\Model\Quiz\Question;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Mapper\QuestionMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindQuestionByIdQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private QuestionMapper $questionMapper
    ) {
    }

    /**
     * @throws DatabaseException
     * @throws CouldNotFindQuestionException
     * @throws InvalidQuestionException
     */
    public function execute(string $id): Question
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('question');
        $query->where('id = :id');
        $query->setParameter('id', $id);

        try {
            $result = $query->executeQuery()->fetchAssociative();
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        if ($result === false) {
            throw new CouldNotFindQuestionException("Could not find the Question with id: $id");
        }

        return $this->questionMapper->map($result);
    }
}
