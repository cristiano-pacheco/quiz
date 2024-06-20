<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Query;

use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Domain\Model\Quiz\Question;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Mapper\QuestionMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class FindQuestionListByQuizIdQuery
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private QuestionMapper $questionMapper
    ) {
    }

    /**
     * @return Question[]
     * @throws DatabaseException
     * @throws InvalidQuestionException
     */
    public function execute(string $quizId): array
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->select('*');
        $query->from('question');
        $query->where('quiz_id = :quiz_id');
        $query->orderBy('sort_order', 'ASC');
        $query->setParameter('quiz_id', $quizId);

        try {
            $result = $query->executeQuery()->fetchAllAssociative();
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        $questionList = [];
        foreach ($result as $question) {
            $questionList[] = $this->questionMapper->map($question);
        }

        return $questionList;
    }
}
