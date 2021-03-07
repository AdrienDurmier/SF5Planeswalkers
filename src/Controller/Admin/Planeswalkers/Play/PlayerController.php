<?php

namespace App\Controller\Admin\Planeswalkers\Play;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\PlayerService;

class PlayerController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/player/lifepoint", name="planeswalkers.play.player.lifepoint", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param PlayerService $playerService
     * @return JsonResponse
     */
    public function lifepoint(Request $request, PublisherInterface $publisher, PlayerService $playerService){
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();

        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $playerService->lifepoint($player, $datas);
        $em->flush();

        // Publication à Mercure
        $topic = 'planeswalkers-game-'.$player->getGame()->getId();
        $datasMercure = [
            'action'        => 'lifepoint',
            'lifepoint'     => $player->getLifepoint(),
            'player'        => $player->getId(),
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }
}