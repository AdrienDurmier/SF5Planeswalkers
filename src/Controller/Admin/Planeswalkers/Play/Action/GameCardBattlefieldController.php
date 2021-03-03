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
use App\Service\Planeswalkers\Play\BattlefieldService;

class GameCardBattlefieldController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/battlefield/tapped", name="planeswalkers.play.action.battlefield.tapped", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param BattlefieldService $battlefieldService
     * @return JsonResponse
     */
    public function tapped(Request $request, PublisherInterface $publisher, BattlefieldService $battlefieldService){
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $action = null;

        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $battlefieldService->tapped($datas);
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