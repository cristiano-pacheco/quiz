<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\UpdateQuiz;

use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Exception\Quiz\CouldNotUpdateQuizException;
use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Application\UseCase\Quiz\Data\QuizData;
use App\Code\Application\UseCase\Quiz\Mapper\QuizToQuizDataMapper;
use App\Code\Application\UseCase\Quiz\UpdateQuiz\Data\InputData;
use App\Code\Domain\Exception\Quiz\InvalidQuizException;
use App\Code\Domain\Model\Quiz\Quiz;

class UpdateQuizUseCase
{
    public function __construct(
        private QuizRepositoryInterface $quizRepository,
        private QuizToQuizDataMapper $quizToQuizDataMapper
    ) {
    }

    /**
     * @throws CouldNotUpdateQuizException
     * @throws InvalidQuizException
     */
    public function execute(InputData $input): QuizData
    {
        try {
            $this->quizRepository->findById($input->id);
        } catch (CouldNotFindQuizException $e) {
            throw new CouldNotUpdateQuizException($e->getMessage(), $e->getCode(), $e);
        }

        $quiz = Quiz::Restore($input->id, $input->name);
        $this->quizRepository->update($quiz);

        return $this->quizToQuizDataMapper->map($quiz);
    }
}
