<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizById;

use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Quiz\Data\QuizData;
use App\Code\Application\UseCase\Quiz\Mapper\QuizToQuizDataMapper;

readonly class FindQuizByIdUseCase
{
    public function __construct(
        private QuizRepositoryInterface $quizRepository,
        private QuizToQuizDataMapper $quizToQuizDataMapper
    ) {
    }

    /**
     * @throws CouldNotFindQuizException
     */
    public function execute(ByIdInputData $input): QuizData
    {
        $quiz = $this->quizRepository->findById($input->id);
        return $this->quizToQuizDataMapper->map($quiz);
    }
}
