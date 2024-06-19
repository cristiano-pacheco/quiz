<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizList;

use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Application\UseCase\Quiz\FindQuizList\Data\OutputData;
use App\Code\Application\UseCase\Quiz\FindQuizList\Mapper\QuizToOutputDataMapper;

readonly class FindQuizListUseCase
{
    public function __construct(
        private QuizRepositoryInterface $quizRepository,
        private QuizToOutputDataMapper $quizToOutputMapper
    ) {
    }

    /**
     * @throws CouldNotFindQuizException
     */
    public function execute(): OutputData
    {
        $quizList = $this->quizRepository->findAll();
        return $this->quizToOutputMapper->map($quizList);
    }
}
