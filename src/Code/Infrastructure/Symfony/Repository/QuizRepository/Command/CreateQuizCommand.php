<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\QuizRepository\Command;

use App\Code\Domain\Model\Quiz\Quiz;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class CreateQuizCommand
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

        $query->insert('quiz');
        $query->values([ 'id' => ':id', 'name' => ':name' ]);
        $query->setParameter('id', $quiz->id->value);
        $query->setParameter('name', $quiz->name);

        try {
            $query->executeQuery();
        } catch (Exception $e) {
            throw new DatabaseException('Could not create the quiz: ' . $e->getMessage());
        }
    }
}
