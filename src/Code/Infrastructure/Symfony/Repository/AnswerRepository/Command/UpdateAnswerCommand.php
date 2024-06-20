<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Command;

use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Mapper\ArrayToJsonMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class UpdateAnswerCommand
{
    public function __construct(
        private DbalConnection $dbalConnection,
        private ArrayToJsonMapper $arrayToJsonMapper
    ) {
    }

    /**
     * @throws DatabaseException
     */
    public function execute(Answer $answer): void
    {
        $query = $this->dbalConnection->createQueryBuilder();

        $query->update('answer');
        $query->where('id = :id');
        $query->set('answer', ':answer');
        $query->set('sort_order', ':sort_order');
        $query->set('behavior', ':behavior');
        $query->set('restriction', ':restriction');
        $query->set('question_to_ask', ':question_to_ask');
        $query->set('excluded_product_ids', ':excluded_product_ids');
        $query->set('recommended_product_ids', ':recommended_product_ids');

        $query->setParameter('id', $answer->id->value);
        $query->setParameter('answer', $answer->answer);
        $query->setParameter('sort_order', $answer->sortOrder);
        $query->setParameter('behavior', $answer->behavior->value);
        $query->setParameter('restriction', $answer->restriction->value);

        $questionToAsk = $answer->questionIdToAsk?->value->toString();
        $query->setParameter('question_to_ask', $questionToAsk);

        $productIdsJson = $this->arrayToJsonMapper->map($answer->excludedProductIds);
        $query->setParameter('excluded_product_ids', $productIdsJson);

        $productIdsJson = $this->arrayToJsonMapper->map($answer->recommendedProductIds);
        $query->setParameter('recommended_product_ids', $productIdsJson);

        try {
            $query->executeStatement();
        } catch (Exception $e) {
            throw new DatabaseException('Could not update the Answer: ' . $e->getMessage());
        }
    }
}
