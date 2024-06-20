<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad;

use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Exception\Quiz\CouldNotFindQuizException;
use App\Code\Application\Repository\QuestionRepositoryInterface;
use App\Code\Application\Repository\QuizRepositoryInterface;
use App\Code\Application\UseCase\Data\ByIdInputData;
use App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Data\OutputData;
use App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Mapper\OutputMapper;
use App\Code\Infrastructure\Symfony\Repository\AnswerRepository\AnswerRepository;

readonly class FindQuizByIdEagerLoadUseCase
{
    public function __construct(
        private QuizRepositoryInterface $quizRepository,
        private QuestionRepositoryInterface $questionRepository,
        private AnswerRepository $answerRepository,
        private OutputMapper $outputMapper
    ) {
    }

    /**
     * @throws CouldNotFindQuizException
     * @throws CouldNotFindAnswerException
     * @throws CouldNotFindQuestionException
     */
    public function execute(ByIdInputData $input): OutputData
    {
        $quiz = $this->quizRepository->findById($input->id);
        $questionList = $this->questionRepository->findQuestionListByQuizId($quiz->id->value->toString());
        $questionIdList = array_map(static fn($question) => $question->id->value->toString(), $questionList);
        $answerList = $this->answerRepository->findAnswerListByQuestionIdList($questionIdList);

        return $this->outputMapper->map($quiz, $questionList, $answerList);
    }
}
