<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Model\Quiz;

use App\Code\Domain\Exception\Quiz\InvalidAnswerException;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AnswerTest extends TestCase
{
    public function testCreateAnswerAskQuestion(): void
    {
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $answer = 'Answer!';
        $sortOrder = 10;
        $behavior = BehaviorEnum::ASK_QUESTION;
        $restriction = RestrictionEnum::NONE;
        $questionIdToAsk = '95487563-9894-41a0-97ce-bd83500d1164';

        $result = Answer::create(
            questionId: $questionId,
            answer: $answer,
            sortOrder: $sortOrder,
            behavior: $behavior,
            restriction: $restriction,
            questionIdToAsk: $questionIdToAsk
        );

        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($sortOrder, $result->sortOrder);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertSame($questionIdToAsk, $result->questionIdToAsk->value->toString());

        $this->assertCount(0, $result->excludedProductIds);
    }

    public function testCreateAnswerAddProduct(): void
    {
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $answer = 'Answer!';
        $sortOrder = 10;
        $behavior = BehaviorEnum::RECOMMEND_PRODUCTS;
        $restriction = RestrictionEnum::EXCLUDE_PRODUCTS;
        $questionIdToAsk = '95487563-9894-41a0-97ce-bd83500d1164';
        $excludedProductIds = ['39c25bf8-f4a6-46c9-a570-1db3106ce9ed'];
        $recommendProductIds = ['7787d5ed-c7b0-4245-837b-87307b79eb2e'];

        $result = Answer::create(
            questionId: $questionId,
            answer: $answer,
            sortOrder: $sortOrder,
            behavior: $behavior,
            restriction: $restriction,
            questionIdToAsk: $questionIdToAsk,
            excludedProductIds: $excludedProductIds,
            recommendedProductIds: $recommendProductIds
        );

        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($sortOrder, $result->sortOrder);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertNull($result->questionIdToAsk);

        $this->assertCount(1, $result->excludedProductIds);
        $this->assertCount(1, $result->recommendedProductIds);
    }

    public function testRestoreAnswerAskQuestion(): void
    {
        $id = '2ef4f6c2-6c59-4fe3-be1c-fd40b10fabf2';
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $answer = 'Answer!';
        $sortOrder = 10;
        $behavior = BehaviorEnum::ASK_QUESTION;
        $restriction = RestrictionEnum::EXCLUDE_PRODUCTS;
        $questionIdToAsk = '95487563-9894-41a0-97ce-bd83500d1164';
        $excludedProductIds = ['39c25bf8-f4a6-46c9-a570-1db3106ce9ed'];

        $result = Answer::restore(
            id: $id,
            questionId: $questionId,
            answer: $answer,
            sortOrder: $sortOrder,
            behavior: $behavior,
            restriction: $restriction,
            questionIdToAsk: $questionIdToAsk,
            excludedProductIds: $excludedProductIds
        );

        $this->assertSame($id, $result->id->value->toString());
        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($sortOrder, $result->sortOrder);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertSame($questionIdToAsk, $result->questionIdToAsk->value->toString());

        $this->assertCount(1, $result->excludedProductIds);
    }

    public function testRestoreAnswerAddProduct(): void
    {
        $id = '2ef4f6c2-6c59-4fe3-be1c-fd40b10fabf2';
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $answer = 'Answer!';
        $sortOrder = 10;
        $behavior = BehaviorEnum::RECOMMEND_PRODUCTS;
        $restriction = RestrictionEnum::EXCLUDE_PRODUCTS;
        $questionIdToAsk = '95487563-9894-41a0-97ce-bd83500d1164';
        $excludedProductIds = ['39c25bf8-f4a6-46c9-a570-1db3106ce9ed'];
        $recommendedProductIds = ['7787d5ed-c7b0-4245-837b-87307b79eb2e'];

        $result = Answer::restore(
            id: $id,
            questionId: $questionId,
            answer: $answer,
            sortOrder: $sortOrder,
            behavior: $behavior,
            restriction: $restriction,
            questionIdToAsk: $questionIdToAsk,
            excludedProductIds: $excludedProductIds,
            recommendedProductIds: $recommendedProductIds
        );

        $this->assertSame($id, $result->id->value->toString());
        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($sortOrder, $result->sortOrder);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertNull($result->questionIdToAsk);

        $this->assertCount(1, $result->excludedProductIds);
        $this->assertCount(1, $result->recommendedProductIds);
    }

    #[DataProvider('createValidationDataProvider')]
    public function testCreateValidations(array $data): void
    {
        $this->expectException(InvalidAnswerException::class);
        Answer::create(
            questionId: $data['questionId'],
            answer: $data['answer'],
            sortOrder: $data['sortOrder'],
            behavior: $data['behavior'],
            restriction: $data['restriction'],
            questionIdToAsk: $data['questionIdToAsk'],
            excludedProductIds: $data['excludedProductIds'],
            recommendedProductIds: $data['recommendedProductIds']
        );
    }

    public static function createValidationDataProvider(): array
    {
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $max = 255;
        $maxString = str_repeat('P', $max + 1);
        $validAnswer = 'Yes';
        return [
            'Empty questionId' => [
                [
                    'questionId' => '',
                    'answer' => '',
                    'sortOrder' => 0,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => '',
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Invalid questionId' => [
                [
                    'questionId' => 'test',
                    'answer' => '',
                    'sortOrder' => 0,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => '',
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Invalid answer (min length)' => [
                [
                    'questionId' => $questionId,
                    'answer' => '',
                    'sortOrder' => 0,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => '',
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Invalid answer (max length)' => [
                [
                    'questionId' => $questionId,
                    'answer' => $maxString,
                    'sortOrder' => 1,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => '',
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Invalid sortOrder' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'sortOrder' => -1,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => '',
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Invalid question to ask id' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'sortOrder' => 100,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => 'test',
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Invalid excluded product ids' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'sortOrder' => 100,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => $questionId,
                    'excludedProductIds' => [$questionId, 'test'],
                    'recommendedProductIds' => []
                ],
            ],
            'Question to ask is required' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'sortOrder' => 100,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::NONE,
                    'questionIdToAsk' => '',
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Excluded products is required' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'sortOrder' => 100,
                    'behavior' => BehaviorEnum::NONE,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionIdToAsk' => null,
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
            'Behavior add products is required' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'sortOrder' => 100,
                    'behavior' => BehaviorEnum::RECOMMEND_PRODUCTS,
                    'restriction' => RestrictionEnum::NONE,
                    'questionIdToAsk' => null,
                    'excludedProductIds' => [],
                    'recommendedProductIds' => []
                ],
            ],
        ];
    }
}
