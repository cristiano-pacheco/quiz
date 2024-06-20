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
    public function execute(ByIdInputData $input): void
    {
        $question = $this->answerRepository->findById($input->id);
        $this->answerRepository->delete($question);
    }
}
