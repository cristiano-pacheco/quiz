<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Service\ProductRecommendation\Validator;

use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use App\Code\Domain\Service\ProductRecommendation\Data\Input;
use App\Code\Domain\Service\ProductRecommendation\Exception\InvalidProductRecommendationInputException;
use App\Code\Domain\Service\ProductRecommendation\Validator\InputValidator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class InputValidatorTest extends TestCase
{
    private InputValidator $sut;

    protected function setUp(): void
    {
        $this->sut = new InputValidator();
    }

    public function testValidate(): void
    {
        $questionId = '7787d5ed-c7b0-4245-837b-87307b79eb2e';
        $answer = 'Yes';
        $order = 10;
        $behavior = BehaviorEnum::NONE;
        $restriction = RestrictionEnum::NONE;

        $answer = Answer::Create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: $behavior,
            restriction: $restriction
        );

        $input = new Input([$answer]);

        $this->sut->validate($input);
    }

    #[DataProvider('dataProvider')]
    public function testValidations($input): void
    {
        $this->expectException(InvalidProductRecommendationInputException::class);
        $this->sut->validate($input);
    }

    public static function dataProvider(): array
    {
        return [
            'empty answers' => [new Input([])],
            'invalid answer' => [new Input(['answer'])],
        ];
    }
}
