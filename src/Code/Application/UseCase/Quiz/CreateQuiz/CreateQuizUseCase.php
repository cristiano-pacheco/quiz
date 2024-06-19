<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\CreateQuiz;

use App\Code\Application\Exception\Quiz\CouldNotCreateQuizException;
use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Application\UseCase\Quiz\CreateQuiz\Data\InputData;
use App\Code\Application\UseCase\Quiz\Data\QuizData;
use App\Code\Application\UseCase\Quiz\Mapper\QuizToQuizDataMapper;
use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use App\Code\Domain\Model\Quiz\Quiz;

readonly class CreateQuizUseCase
{
    public function __construct(
        private QuizRepositoryInterface $quizRepository,
        private QuizToQuizDataMapper $quizToQuizDataMapper
    ) {
    }

    /**
     * @throws InvalidQuizException
     * @throws CouldNotCreateQuizException
     */
    public function execute(InputData $input): QuizData
    {
        $quiz = Quiz::create($input->name);
        $this->quizRepository->create($quiz);
        return $this->quizToQuizDataMapper->map($quiz);
    }
}
