<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Utils\UserUtils;

class RollDiceController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/rolldice/send", name="planeswalkers.play.action.rolldice.send", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @return JsonResponse
     */
    public function send(Request $request, PublisherInterface $publisher)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $player->setRollDiceStartingGame($datas['face']);
        $em->persist($player);
        $em->flush();

        $opponent = $player->getGame()->getOpponent(); // fixme

        // Publication à Mercure
        $topic = 'planeswalkers-game-'.$player->getGame()->getId();
        $datasMercure = [
            'action'   => 'starting-game-roll-dice',
            'player'   => $player->getRollDiceStartingGame(),
            'opponent' => $opponent->getRollDiceStartingGame(),
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}