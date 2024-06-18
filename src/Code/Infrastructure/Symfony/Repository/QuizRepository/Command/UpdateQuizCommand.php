<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command;

use App\Code\Domain\Model\Quiz\Quiz;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class UpdateQuizCommand
{
    public function __construct(private DbalConnection $dbalConnection)
    {
    }

    /**
     * @throws DatabaseException
     */
    public function execute(Quiz $quiz): void
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->update('quiz');
        $query->where('id = :id');
        $query->set('name', ':name');
        $query->setParameter('id', $quiz->id->value);
        $query->setParameter('name', $quiz->name);

        try {
            $query->executeStatement();
        } catch (Exception $e) {
            throw new DatabaseException('Could not update the quiz: ' . $e->getMessage());
        }
    }
}
