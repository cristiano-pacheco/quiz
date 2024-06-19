<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\UpdateQuestion;

use App\Code\Application\Exception\Question\CouldNotFindQuestionException;
use App\Code\Application\Exception\Question\CouldNotUpdateQuestionException;
use App\Code\Application\Repository\QuestionRepositoryInterface;
use App\Code\Application\UseCase\Question\Data\QuestionData;
use App\Code\Application\UseCase\Question\Mapper\QuestionToQuestionDataMapper;
use App\Code\Application\UseCase\Question\UpdateQuestion\Data\InputData;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Domain\Model\Quiz\Question;

readonly class UpdateQuestionUseCase
{
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
        private QuestionToQuestionDataMapper $questionToQuestionDataMapper
    ) {
    }

    /**
     * @throws CouldNotUpdateQuestionException
     * @throws InvalidQuestionException
     */
    public function execute(InputData $input): QuestionData
    {
        try {
            $this->questionRepository->findById($input->id);
        } catch (CouldNotFindQuestionException $e) {
            throw new CouldNotUpdateQuestionException($e->getMessage(), $e->getCode(), $e);
        }

        $question = Question::Restore(
            id: $input->id,
            quizId: $input->quizId,
            question: $input->question,
            sortOrder: $input->sortOrder
        );

        $this->questionRepository->update($question);

        return $this->questionToQuestionDataMapper->map($question);
    }
}
