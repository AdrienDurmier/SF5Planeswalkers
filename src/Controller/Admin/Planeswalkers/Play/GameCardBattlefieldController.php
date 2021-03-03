<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Play\GameCardBattlefield;
use App\Service\Planeswalkers\Play\GameCardBattlefieldService;

class GameCardBattlefieldController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/gamecardbattlefield/tapped", name="planeswalkers.play.action.gamecardbattlefield.tapped", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param GameCardBattlefieldService $gameCardBattlefieldService
     * @return JsonResponse
     */
    public function edit(Request $request, PublisherInterface $publisher, GameCardBattlefieldService $gameCardBattlefieldService){
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $action = null;

        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $gameCardBattlefieldService->tapped($datas);
        $em->flush();

        // Publication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = [
            'log' => $player->getUser() .' tapped TODO.',
            'picto' => '/images/planeswalkers/game-icons-net/lorc/arrow-dunk.svg',
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}