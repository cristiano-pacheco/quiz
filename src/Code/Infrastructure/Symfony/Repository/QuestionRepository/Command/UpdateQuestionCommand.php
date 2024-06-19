<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Command;

use App\Code\Domain\Model\Quiz\Question;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class UpdateQuestionCommand
{
    public function __construct(private DbalConnection $dbalConnection)
    {
    }

    /**
     * @throws DatabaseException
     */
    public function execute(Question $question): void
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->update('question');
        $query->where('id = :id');
        $query->set('question', ':question');
        $query->set('sort_order', ':sort_order');
        $query->setParameter('id', $question->id->value);
        $query->setParameter('quiz_id', $question->quizId->value);
        $query->setParameter('question', $question->question);
        $query->setParameter('sort_order', $question->sortOrder);

        try {
            $query->executeStatement();
        } catch (Exception $e) {
            throw new DatabaseException('Could not update the Question: ' . $e->getMessage());
        }
    }
}
