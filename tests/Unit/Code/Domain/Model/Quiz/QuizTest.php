<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Model\Quiz;

use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use App\Code\Domain\Model\Quiz\Quiz;
use PHPUnit\Framework\TestCase;

final class QuizTest extends TestCase
{
    public function testCreateQuiz(): void
    {
        $name = 'Quiz Name';
        $quiz = Quiz::create($name);
        $this->assertSame($name, $quiz->name);
        $this->assertSame(36, strlen($quiz->id->value->toString()));
    }

    public function testRestoreQuiz(): void
    {
        $name = 'Quiz Name';
        $id = 'd1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b';
        $quiz = Quiz::restore($id, $name);
        $this->assertSame($name, $quiz->name);
        $this->assertSame($id, $quiz->id->value->toString());
    }

    public function testInvalidName(): void
    {
        $exception = InvalidQuizException::class;
        $this->expectException($exception);
        Quiz::create('P');

        $this->expectException($exception);
        Quiz::restore('d1b3b3b3-1b3b-4b3b-8b3b-1b3b3b3b3b3b', 'P');
    }

    public function testInvalidId(): void
    {
        $exception = InvalidQuizException::class;
        $this->expectException($exception);
        Quiz::restore('d1b3b3b3', 'P');
    }
}
