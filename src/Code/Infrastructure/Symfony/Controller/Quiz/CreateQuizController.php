<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Quiz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateQuizController extends AbstractController
{
    #[Route(path: '/quiz/create', name: 'quiz.create', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('quiz/create.html.twig');
    }
}
