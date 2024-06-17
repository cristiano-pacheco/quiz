<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Model\Quiz;

use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Domain\Model\Quiz\Question;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class QuestionTest extends TestCase
{
    public function testCreateQuestion(): void
    {
        $question = 'question?';
        $quizId = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $order = 10;
        $result = Question::create(quizId: $quizId, question: $question, order: $order);
        $this->assertSame($quizId, $result->quizId->value->toString());
        $this->assertSame($question, $result->question);
        $this->assertSame($order, $result->order);
    }

    public function testRestoreQuestion(): void
    {
        $question = 'question?';
        $id = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $quizId = '39c25bf8-f4a6-46c9-a570-1db3106ce9ed';
        $order = 10;
        $result = Question::restore(id: $id, quizId: $quizId, question: $question, order: $order);
        $this->assertSame($id, $result->id->value->toString());
        $this->assertSame($quizId, $result->quizId->value->toString());
        $this->assertSame($question, $result->question);
        $this->assertSame($order, $result->order);
    }

    #[DataProvider('validationCreateDataProvider')]
    public function testCreateValidations(string $quizId, string $question, int $order): void
    {
        $exception = InvalidQuestionException::class;
        $this->expectException($exception);
        Question::create(quizId: $quizId, question: $question, order: $order);
    }

    public static function validationCreateDataProvider(): array
    {
        $id = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $max = 500;
        $maxString = str_repeat('P', $max + 1);
        $validQuestion = 'is a valid question?';

        return [
            'invalid_empty_question' => [$id, '', 100],
            'invalid_min_question' => [$id, 'PPP', 100],
            'invalid_max_question' => [$id, $maxString, 100],
            'invalid_question_id' => ['invalid id', $validQuestion, 100],
            'invalid_order' => [$id, $validQuestion, -100],
        ];
    }

    #[DataProvider('validationRestoreDataProvider')]
    public function testRestoreValidations(string $id, string $quizId, string $question, int $order): void
    {
        $exception = InvalidQuestionException::class;
        $this->expectException($exception);
        Question::restore(id: $id, quizId: $quizId, question: $question, order: $order);
    }

    public static function validationRestoreDataProvider(): array
    {
        $id = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $max = 500;
        $maxString = str_repeat('P', $max + 1);
        $validQuestion = 'is a valid question?';

        return [
            'invalid_empty_question' => [$id, $id, '', 100],
            'invalid_min_question' => [$id, $id, 'PPP', 100],
            'invalid_max_question' => [$id, $id, $maxString, 100],
            'invalid_id' => ['invalid id', $id, $validQuestion, 100],
            'invalid_question_id' => [$id, 'invalid id', $validQuestion, 100],
            'invalid_order' => [$id, $id, $validQuestion, -100],
        ];
    }
}
