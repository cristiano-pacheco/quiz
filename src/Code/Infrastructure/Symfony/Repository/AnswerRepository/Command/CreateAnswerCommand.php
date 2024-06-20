<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Command;

use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Infrastructure\Symfony\Exception\DatabaseException;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\Mapper\ArrayToJsonMapper;
use Doctrine\DBAL\Connection as DbalConnection;
use Exception;

readonly class CreateAnswerCommand
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

        $query->insert('answer');

        $bindings = [
            'id' => ':id',
            'question_id' => ':question_id',
            'answer' => ':answer',
            'sort_order' => ':sort_order',
            'behavior' => ':behavior',
            'restriction' => ':restriction',
        ];

        if ($answer->questionIdToAsk) {
            $bindings['question_to_ask'] = ':question_to_ask';
        }

        if ($answer->excludedProductIds) {
            $bindings['excluded_product_ids'] = ':excluded_product_ids';
        }

        if ($answer->recommendedProductIds) {
            $bindings['recommended_product_ids'] = ':recommended_product_ids';
        }

        $query->values($bindings);

        $query->setParameter('id', $answer->id->value);
        $query->setParameter('question_id', $answer->questionId->value);
        $query->setParameter('answer', $answer->answer);
        $query->setParameter('sort_order', $answer->sortOrder);
        $query->setParameter('behavior', $answer->behavior->value);
        $query->setParameter('restriction', $answer->restriction->value);

        if ($answer->questionIdToAsk) {
            $query->setParameter('question_to_ask', $answer->questionIdToAsk->value->toString());
        }

        if ($answer->excludedProductIds) {
            $productIdsJson = $this->arrayToJsonMapper->map($answer->excludedProductIds);
            $query->setParameter('excluded_product_ids', $productIdsJson);
        }

        if ($answer->recommendedProductIds) {
            $productIdsJson = $this->arrayToJsonMapper->map($answer->recommendedProductIds);
            $query->setParameter('recommended_product_ids', $productIdsJson);
        }

        try {
            $query->executeStatement();
        } catch (Exception $e) {
            throw new DatabaseException('Could not create the Answer: ' . $e->getMessage());
        }
    }
}
