<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\DeleteQuizById;

use App\Code\Application\Exception\Quiz\CouldNotDeleteQuizException;
use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class DeleteQuizByIdUseCase
{
    public function __construct(private QuizRepositoryInterface $quizRepository)
    {
    }

    /**
     * @throws CouldNotFindQuizException
     * @throws CouldNotDeleteQuizException
     */
    public function execute(ByIdInputData $inputData): void
    {
        $quiz = $this->quizRepository->findById($inputData->id);
        $this->quizRepository->delete($quiz);
    }
}
