<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function indexAction(): Response
    {
        return $this->redirectToRoute('quiz.index');
    }
}
