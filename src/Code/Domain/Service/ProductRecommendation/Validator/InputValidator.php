<?php

declare(strict_types=1);

namespace App\Code\Domain\Service\ProductRecommendation\Validator;

use App\Code\Domain\Model\Quiz\Answer;
use App\Code\Domain\Service\ProductRecommendation\Data\Input;
use App\Code\Domain\Service\ProductRecommendation\Exception\InvalidProductRecommendationInputException;

class InputValidator
{
    /**
     * @throws InvalidProductRecommendationInputException
     */
    public function validate(Input $input): void
    {
        if (!$input->answers) {
            throw new InvalidProductRecommendationInputException('Answers are required');
        }

        foreach ($input->answers as $answer) {
            if (!$answer instanceof Answer) {
                $message = sprintf('The answer must be instances of the %s class', Answer::class);
                throw new InvalidProductRecommendationInputException($message);
            }
        }
    }
}
