<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuestionRepository\Command;

use App\Code\Domain\Model\Quiz\Question;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class DeleteQuestionCommand
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

        $query->delete('question');
        $query->where('id = :id');
        $query->setParameter('id', $question->id->value);

        try {
            $query->executeStatement();
        } catch (Exception $e) {
            throw new DatabaseException('Could not delete the Question: ' . $e->getMessage());
        }
    }
}
