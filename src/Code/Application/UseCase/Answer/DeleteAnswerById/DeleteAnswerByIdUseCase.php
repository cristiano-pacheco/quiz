<?php

declare(strict_types=1);

namespace App\Code\Application\UseCase\Answer\DeleteAnswerById;

use App\Code\Application\Exception\Answer\CouldNotDeleteAnswerException;
use App\Code\Application\Exception\Answer\CouldNotFindAnswerException;
use App\Code\Application\Repository\AnswerRepositoryInterface;
use App\Code\Application\UseCase\Data\ByIdInputData;

readonly class DeleteAnswerByIdUseCase
{
    public function __construct(private AnswerRepositoryInterface $answerRepository)
    {
    }

    /**
     * @throws CouldNotFindAnswerException
     * @throws CouldNotDeleteAnswerException
     */
    public function execute(ByIdInputData $inputData): void
    {
        $question = $this->answerRepository->findById($inputData->id);
        $this->answerRepository->delete($question);
    }
}
