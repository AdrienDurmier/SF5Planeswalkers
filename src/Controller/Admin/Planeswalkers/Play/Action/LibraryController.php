<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\LibraryService;

class LibraryController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/library/shuffle", name="planeswalkers.play.action.library.shuffle", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param LibraryService $libraryService
     * @return JsonResponse
     */
    public function shuffle(Request $request,
                         PublisherInterface $publisher,
                         LibraryService $libraryService)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $action = null;

        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $libraryService->shuffle($player->getLibrary());
        $em->flush();

        // Plublication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = [
            'message' => $player->getUser() .' shuffle his library.',
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}