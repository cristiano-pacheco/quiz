<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Command;

use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class DeleteAnswerCommand
{
    public function __construct(private DbalConnection $dbalConnection)
    {
    }

    /**
     * @throws DatabaseException
     */
    public function execute(Answer $answer): void
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->delete('answer');
        $query->where('id = :id');
        $query->setParameter('id', $answer->id->value);

        try {
            $query->executeStatement();
        } catch (Exception $e) {
            throw new DatabaseException('Could not delete the Answer: ' . $e->getMessage());
        }
    }
}
