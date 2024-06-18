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
        $order = 10;
        $behavior = BehaviorEnum::ASK_QUESTION;
        $restriction = RestrictionEnum::EXCLUDE_PRODUCTS;
        $questionToAskId = '95487563-9894-41a0-97ce-bd83500d1164';
        $excludedProductIds = ['39c25bf8-f4a6-46c9-a570-1db3106ce9ed'];

        $result = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: $behavior,
            restriction: $restriction,
            questionToAskId: $questionToAskId,
            excludedProductIds: $excludedProductIds
        );

        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($order, $result->order);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertSame($questionToAskId, $result->questionToAskId->value->toString());

        $this->assertCount(1, $result->excludedProductIds);
        $this->assertSame($excludedProductIds[0], $result->excludedProductIds[0]->value->toString());
    }

    public function testCreateAnswerAddProduct(): void
    {
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $answer = 'Answer!';
        $order = 10;
        $behavior = BehaviorEnum::RECOMMEND_PRODUCTS;
        $restriction = RestrictionEnum::EXCLUDE_PRODUCTS;
        $questionToAskId = '95487563-9894-41a0-97ce-bd83500d1164';
        $excludedProductIds = ['39c25bf8-f4a6-46c9-a570-1db3106ce9ed'];
        $recommendProductIds = ['7787d5ed-c7b0-4245-837b-87307b79eb2e'];

        $result = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: $behavior,
            restriction: $restriction,
            questionToAskId: $questionToAskId,
            excludedProductIds: $excludedProductIds,
            recommendedProductIds: $recommendProductIds
        );

        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($order, $result->order);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertSame($questionToAskId, $result->questionToAskId->value->toString());

        $this->assertCount(1, $result->excludedProductIds);
        $this->assertSame($excludedProductIds[0], $result->excludedProductIds[0]->value->toString());

        $this->assertCount(1, $result->recommendedProductIds);
        $this->assertSame($recommendProductIds[0], $result->recommendedProductIds[0]->value->toString());
    }

    public function testRestoreAnswerAskQuestion(): void
    {
        $id = '2ef4f6c2-6c59-4fe3-be1c-fd40b10fabf2';
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $answer = 'Answer!';
        $order = 10;
        $behavior = BehaviorEnum::ASK_QUESTION;
        $restriction = RestrictionEnum::EXCLUDE_PRODUCTS;
        $questionToAskId = '95487563-9894-41a0-97ce-bd83500d1164';
        $excludedProductIds = ['39c25bf8-f4a6-46c9-a570-1db3106ce9ed'];

        $result = Answer::restore(
            id: $id,
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: $behavior,
            restriction: $restriction,
            questionToAskId: $questionToAskId,
            excludedProductIds: $excludedProductIds
        );

        $this->assertSame($id, $result->id->value->toString());
        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($order, $result->order);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertSame($questionToAskId, $result->questionToAskId->value->toString());

        $this->assertCount(1, $result->excludedProductIds);
        $this->assertSame($excludedProductIds[0], $result->excludedProductIds[0]->value->toString());
    }

    public function testRestoreAnswerAddProduct(): void
    {
        $id = '2ef4f6c2-6c59-4fe3-be1c-fd40b10fabf2';
        $questionId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $answer = 'Answer!';
        $order = 10;
        $behavior = BehaviorEnum::RECOMMEND_PRODUCTS;
        $restriction = RestrictionEnum::EXCLUDE_PRODUCTS;
        $questionToAskId = '95487563-9894-41a0-97ce-bd83500d1164';
        $excludedProductIds = ['39c25bf8-f4a6-46c9-a570-1db3106ce9ed'];
        $recommendedProductIds = ['7787d5ed-c7b0-4245-837b-87307b79eb2e'];

        $result = Answer::restore(
            id: $id,
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: $behavior,
            restriction: $restriction,
            questionToAskId: $questionToAskId,
            excludedProductIds: $excludedProductIds,
            recommendedProductIds: $recommendedProductIds
        );

        $this->assertSame($id, $result->id->value->toString());
        $this->assertSame($questionId, $result->questionId->value->toString());
        $this->assertSame($answer, $result->answer);
        $this->assertSame($order, $result->order);
        $this->assertSame($behavior, $result->behavior);
        $this->assertSame($restriction, $result->restriction);
        $this->assertSame($questionToAskId, $result->questionToAskId->value->toString());

        $this->assertCount(1, $result->excludedProductIds);
        $this->assertSame($excludedProductIds[0], $result->excludedProductIds[0]->value->toString());

        $this->assertCount(1, $result->recommendedProductIds);
        $this->assertSame($recommendedProductIds[0], $result->recommendedProductIds[0]->value->toString());
    }

    #[DataProvider('createValidationDataProvider')]
    public function testCreateValidations(array $data): void
    {
        $this->expectException(InvalidAnswerException::class);
        Answer::create(
            questionId: $data['questionId'],
            answer: $data['answer'],
            order: $data['order'],
            behavior: $data['behavior'],
            restriction: $data['restriction'],
            questionToAskId: $data['questionToAskId'],
            excludedProductIds: $data['excludedProductIds'],
            recommendedProductIds: $data['recommendedProductIds'] ?? []
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
                    'order' => 0,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => '',
                    'excludedProductIds' => []
                ],
            ],
            'Invalid questionId' => [
                [
                    'questionId' => 'test',
                    'answer' => '',
                    'order' => 0,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => '',
                    'excludedProductIds' => []
                ],
            ],
            'Invalid answer (min length)' => [
                [
                    'questionId' => $questionId,
                    'answer' => '',
                    'order' => 0,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => '',
                    'excludedProductIds' => []
                ],
            ],
            'Invalid answer (max length)' => [
                [
                    'questionId' => $questionId,
                    'answer' => $maxString,
                    'order' => 1,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => '',
                    'excludedProductIds' => []
                ],
            ],
            'Invalid order' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'order' => -1,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => '',
                    'excludedProductIds' => []
                ],
            ],
            'Invalid question to ask id' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'order' => 100,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => 'test',
                    'excludedProductIds' => []
                ],
            ],
            'Invalid excluded product ids' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'order' => 100,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => $questionId,
                    'excludedProductIds' => [$questionId, 'test']
                ],
            ],
            'Question to ask is required' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'order' => 100,
                    'behavior' => BehaviorEnum::ASK_QUESTION,
                    'restriction' => RestrictionEnum::NONE,
                    'questionToAskId' => null,
                    'excludedProductIds' => null
                ],
            ],
            'Excluded products is required' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'order' => 100,
                    'behavior' => BehaviorEnum::NONE,
                    'restriction' => RestrictionEnum::EXCLUDE_PRODUCTS,
                    'questionToAskId' => null,
                    'excludedProductIds' => null
                ],
            ],
            'Behavior add products is required' => [
                [
                    'questionId' => $questionId,
                    'answer' => $validAnswer,
                    'order' => 100,
                    'behavior' => BehaviorEnum::RECOMMEND_PRODUCTS,
                    'restriction' => RestrictionEnum::NONE,
                    'questionToAskId' => null,
                    'excludedProductIds' => null,
                    'recommendedProductIds' => null
                ],
            ],
        ];
    }
}
