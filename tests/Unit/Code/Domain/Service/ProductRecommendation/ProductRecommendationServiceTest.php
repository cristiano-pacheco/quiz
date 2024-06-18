<?php

declare(strict_types=1);

namespace Unit\Code\Domain\Service\ProductRecommendation;

use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use App\Code\Domain\Service\ProductRecommendation\Data\Input;
use App\Code\Domain\Service\ProductRecommendation\Exception\InvalidProductRecommendationInputException;
use App\Code\Domain\Service\ProductRecommendation\ProductRecommendationService;
use App\Code\Domain\Service\ProductRecommendation\Registry\ProductRegistry;
use App\Code\Domain\Service\ProductRecommendation\Validator\InputValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ProductRecommendationServiceTest extends TestCase
{
    private ProductRecommendationService $sut;
    private InputValidator|MockObject $inputValidatorMock;
    private ProductRegistry|MockObject $productRegistryMock;

    protected function setUp(): void
    {
        $this->inputValidatorMock = $this->createMock(InputValidator::class);
        $this->productRegistryMock = $this->createMock(ProductRegistry::class);
        $this->sut = new ProductRecommendationService($this->inputValidatorMock, $this->productRegistryMock);
    }

    public function testExecute(): void
    {
        $recommendedProductId = '87428d3e-22c2-4ca8-a12d-20793acb9088';
        $recommendedProductIdTwo = '9cf436f8-73e9-4fcd-80e8-204eb4f00170';
        $excludedProductId = '87428d3e-22c2-4ca8-a12d-20793acb9088';

        $input = $this->getInput($recommendedProductId, $recommendedProductIdTwo, $excludedProductId);

        $this->inputValidatorMock->expects($this->once())->method('validate');

        $sut = new ProductRecommendationService($this->inputValidatorMock, new ProductRegistry());

        $result = $sut->execute($input);

        $this->assertCount(1, $result->productIds);

        $productId = $result->productIds[$recommendedProductIdTwo]->value->toString();
        $this->assertSame($recommendedProductIdTwo, $productId);
    }

    public function testItShouldEarlierReturnWhenTheAnswerIsNotValid(): void
    {
        $exception = new InvalidProductRecommendationInputException();
        $this->inputValidatorMock->expects($this->once())->method('validate')->willThrowException($exception);

        $this->expectException(InvalidProductRecommendationInputException::class);
        $this->productRegistryMock->expects($this->never())->method('reset');
        $this->productRegistryMock->expects($this->never())->method('add');
        $this->productRegistryMock->expects($this->never())->method('remove');

        $this->sut->execute(new Input([]));
    }

    #[DataProvider('excludeProductsDataProvider')]
    public function testItShouldExcludeAllProducts($answer): void
    {
        $this->inputValidatorMock->expects($this->once())->method('validate');
        $this->productRegistryMock->expects($this->once())->method('reset');

        $result = $this->sut->execute(new Input([$answer]));

        $this->assertCount(0, $result->productIds);
        $this->productRegistryMock->expects($this->never())->method('reset');
        $this->productRegistryMock->expects($this->never())->method('add');
        $this->productRegistryMock->expects($this->never())->method('remove');
    }

    public static function excludeProductsDataProvider(): array
    {
        $questionId = '7787d5ed-c7b0-4245-837b-87307b79eb2e';
        $answer = 'Yes';
        $order = 10;

        $answerOne = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: BehaviorEnum::EXCLUDE_ALL_PRODUCTS,
            restriction: RestrictionEnum::NONE
        );

        $answerTwo = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: BehaviorEnum::NONE,
            restriction: RestrictionEnum::EXCLUDE_ALL_PRODUCTS
        );

        return [
            'exclude all products with behavior' => [$answerOne],
            'exclude all products with restriction' => [$answerTwo],
        ];
    }

    private function getInput(
        string $recommendedProductId,
        string $recommendedProductIdTwo,
        string $excludedProductId
    ): Input {
        $questionId = '7787d5ed-c7b0-4245-837b-87307b79eb2e';
        $answer = 'Yes';
        $order = 10;

        $answerOne = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: BehaviorEnum::NONE,
            restriction: RestrictionEnum::NONE
        );

        $answerTwo = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: BehaviorEnum::NONE,
            restriction: RestrictionEnum::NONE
        );

        $answerThree = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: BehaviorEnum::RECOMMEND_PRODUCTS,
            restriction: RestrictionEnum::NONE,
            recommendedProductIds: [$recommendedProductId]
        );

        $answerFour = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: BehaviorEnum::RECOMMEND_PRODUCTS,
            restriction: RestrictionEnum::NONE,
            recommendedProductIds: [$recommendedProductIdTwo]
        );

        $answerFive = Answer::create(
            questionId: $questionId,
            answer: $answer,
            order: $order,
            behavior: BehaviorEnum::NONE,
            restriction: RestrictionEnum::EXCLUDE_PRODUCTS,
            excludedProductIds: [$excludedProductId]
        );

        return new Input([$answerOne, $answerTwo, $answerThree, $answerFour, $answerFive]);
    }
}
