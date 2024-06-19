<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Question\CreateQuestion;

use App\Code\Application\Exception\Question\CouldNotCreateQuestionException;
use App\Code\Application\Repository\QuestionRepositoryInterface;
use App\Code\Application\UseCase\Question\CreateQuestion\Data\InputData;
use App\Code\Application\UseCase\Question\Data\QuestionData;
use App\Code\Application\UseCase\Question\Mapper\QuestionToQuestionDataMapper;
use App\Code\Domain\Exception\Quiz\InvalidQuestionException;
use App\Code\Domain\Model\Quiz\Question;

readonly class CreateQuestionUseCase
{
    public function __construct(
        private QuestionRepositoryInterface $QuestionRepository,
        private QuestionToQuestionDataMapper $QuestionToQuestionDataMapper
    ) {
    }

    /**
     * @throws InvalidQuestionException
     * @throws CouldNotCreateQuestionException
     */
    public function execute(InputData $input): QuestionData
    {
        $question = Question::create(quizId: $input->quizId, question: $input->question, sortOrder: $input->sortOrder);
        $this->QuestionRepository->create($question);
        return $this->QuestionToQuestionDataMapper->map($question);
    }
}
