<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuizRepository\Query;

use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use App\Code\Domain\Model\Quiz\Quiz;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\QuizRepository\Mapper\QuizMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindAllQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private QuizMapper $quizMapper
    ) {
    }

    /**
     * @return Quiz[]
     * @throws DatabaseException
     * @throws InvalidQuizException
     */
    public function execute(): array
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('quiz');

        try {
            $result = $query->executeQuery()->fetchAllAssociative();
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        $quizList = [];
        foreach ($result as $quiz) {
            $quizList[] = $this->quizMapper->map($quiz);
        }

        return $quizList;
    }
}
