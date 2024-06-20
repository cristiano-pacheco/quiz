<?php

declare(strict_types=1);

namespace App\Code\Infrastructure\Symfony\Controller\Answer;

use App\Code\Domain\Model\Quiz\Enum\BehaviorEnum;
use App\Code\Domain\Model\Quiz\Enum\RestrictionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateAnswerController extends AbstractController
{
    #[Route(path: '/answer/create/{questionId}', name: 'answer.create', methods: [ 'GET' ])]
    public function __invoke(Request $request): Response
    {
        /** @var string $questionId */
        $questionId = $request->get('questionId', '');

        $behaviors = BehaviorEnum::toArray();
        $restrictions = RestrictionEnum::toArray();

        return $this->render('answer/create.html.twig', [ 'questionId' => $questionId ]);
    }
}
