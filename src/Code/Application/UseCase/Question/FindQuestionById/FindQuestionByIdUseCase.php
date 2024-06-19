<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\FindQuestionById;

use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Repository\QuestionRepositoryInterface;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Question\Data\QuestionData;
use App\Code\Application\UseCase\Question\Mapper\QuestionToQuestionDataMapper;

readonly class FindQuestionByIdUseCase
{
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
        private QuestionToQuestionDataMapper $questionToQuestionDataMapper
    ) {
    }

    /**
     * @throws CouldNotFindQuestionException
     */
    public function execute(ByIdInputData $input): QuestionData
    {
        $Question = $this->questionRepository->findById($input->id);
        return $this->questionToQuestionDataMapper->map($Question);
    }
}
