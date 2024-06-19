<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\DeleteQuestionById;

use App\Code\Application\Exception\Question\CouldNotDeleteQuestionException;
use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Repository\QuestionRepositoryInterface;
use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class DeleteQuestionByIdUseCase
{
    public function __construct(private QuestionRepositoryInterface $questionRepository)
    {
    }

    /**
     * @throws CouldNotFindQuestionException
     * @throws CouldNotDeleteQuestionException
     */
    public function execute(ByIdInputData $inputData): void
    {
        $question = $this->questionRepository->findById($inputData->id);
        $this->questionRepository->delete($question);
    }
}
