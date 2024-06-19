<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuizRepository\Query;

use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Exception\Quiz\QuizNotFoundException;
use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use App\Code\Domain\Model\Quiz\Quiz;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Mapper\QuizMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindQuizByIdQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private QuizMapper $quizMapper
    ) {
    }

    /**
     * @throws DatabaseException
     * @throws CouldNotFindQuizException
     * @throws InvalidQuizException
     */
    public function execute(string $id): Quiz
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('quiz');
        $query->where('id = :id');
        $query->setParameter('id', $id);

        try {
            $result = $query->executeQuery()->fetchAssociative();
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        if ($result === false) {
            throw new CouldNotFindQuizException("Could not find the quiz with id: $id");
        }

        return $this->quizMapper->map($result);
    }
}
