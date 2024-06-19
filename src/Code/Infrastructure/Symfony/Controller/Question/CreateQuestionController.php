<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Question;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateQuestionController extends AbstractController
{
    #[Route(path: '/question/create/{quizId}', name: 'question.create', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        $quizId = $request->get('quizId', '');
        return $this->render('question/create.html.twig', [ 'quizId' => $quizId ]);
    }
}
