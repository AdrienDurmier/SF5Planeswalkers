<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use App\Entity\Planeswalkers\Play\Game;
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

        $game = $this->getDoctrine()->getRepository(Game::class)->find($datas['game']);
        $player = $game->getPlayer($this->getUser());
        $opponent = $game->getOpponent($this->getUser());

        $player->setRollDiceStartingGame($datas['face']);
        $em->persist($player);

        $egality = false;
        if ($opponent->getRollDiceStartingGame() != null){
            // Si égalité
            if ($player->getRollDiceStartingGame() == $opponent->getRollDiceStartingGame()){
                $egality = true;
            }
            // Si il a un lancé plus fort qu'un autre
            if ($player->getRollDiceStartingGame() > $opponent->getRollDiceStartingGame()){
                $game->setPlayerActive($player);
            }
            if ($player->getRollDiceStartingGame() < $opponent->getRollDiceStartingGame()){
                $game->setPlayerActive($opponent);
            }
            $em->persist($game);
        }
        $em->flush();

        // Publication à Mercure
        $topic = 'planeswalkers-game-'.$game->getId();
        $datasMercure = [
            'action'        => 'starting-game-roll-dice',
            'playerActive'  => $game->getPlayerActive()->getId(),
            'egality'       => $egality,
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}