<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Mapper;

use App\Code\Application\UseCase\Answer\Mapper\AnswerToAnswerDataMapper;
use App\Code\Application\UseCase\Question\Mapper\QuestionToQuestionDataMapper;
use App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Data\OutputData;
use App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Data\QuestionData;
use App\Code\Application\UseCase\Quiz\FindQuizByIdEagerLoad\Data\QuizData;
use App\Code\Application\UseCase\Quiz\Mapper\QuizToQuizDataMapper;
use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Model\Quiz\Question;
use App\Code\Domain\Model\Quiz\Quiz;

readonly class OutputMapper
{
    public function __construct(
        private QuizToQuizDataMapper $quizToQuizDataMapper,
        private AnswerToAnswerDataMapper $answerToAnswerDataMapper,
        private QuestionToQuestionDataMapper $questionToQuestionDataMapper
    ) {
    }
    /**
     * @param Question[] $questionList
     * @param Answer[] $answerList
     */
    public function map(Quiz $quiz, array $questionList, array $answerList): OutputData
    {
        $questionListData = [];
        $indexedListAnswerList = [];
        foreach ($answerList as $answer) {
            $indexedListAnswerList[$answer->questionId->value->toString()][] = $answer;
        }

        foreach ($questionList as $question) {
            $questionId = $question->id->value->toString();
            $answerListData = [];
            if (isset($indexedListAnswerList[$questionId])) {
                foreach ($indexedListAnswerList[$questionId] as $answer) {
                    $answerListData[] = $this->answerToAnswerDataMapper->map($answer);
                }
            }

            $defaultQuestionData = $this->questionToQuestionDataMapper->map($question);
            $questionData = new QuestionData($defaultQuestionData, $answerListData);
            $questionListData[] = $questionData;
        }

        $defaultQuizData = $this->quizToQuizDataMapper->map($quiz);
        $quiz = new QuizData(quiz: $defaultQuizData, questionList: $questionListData);

        return new OutputData($quiz);
    }
}
