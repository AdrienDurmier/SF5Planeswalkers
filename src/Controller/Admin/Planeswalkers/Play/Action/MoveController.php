<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use App\Entity\Planeswalkers\Play\Battlefield;
use App\Entity\Planeswalkers\Play\GameCardBattlefield;
use App\Service\Planeswalkers\Play\PlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\Action\MoveService;

class MoveController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/move", name="planeswalkers.play.action.move", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param MoveService $moveService
     * @param PlayerService $playerService
     * @return JsonResponse
     */
    public function move(Request $request, PublisherInterface $publisher, MoveService $moveService, PlayerService $playerService){
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $action = null;
        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);

        // Ensemble des scénarios lors du déplacement d'une carte
        if ($datas['from'] == 'battlefield' && $datas['to'] == 'battlefield'){
            $moveService->battlefield($datas);
        }else{
            $moveService->move($player, $datas);
        }
        $em->flush();

        // Publication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = [
            'log'      => $this->getMoveMessage($player, $datas['from'], $datas['to'], 1),
            'picto'    => $this->getPictoMove($datas['from'], $datas['to']),
            'move'     =>  [
                'from'     =>  $datas['from'],
                'to'       =>  $datas['to'],
            ],
            'player'   =>  $player->getId(),
            'areas'    =>  $playerService->areas($player),
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

    /**
     * @param $player
     * @param $from
     * @param $to
     * @param int $quantity
     * @return null
     */
    public function getMoveMessage($player, $from, $to, int $quantity){
        $message = null;
        if ($from == 'library' && $to == 'hand'){
            $message = $player->getUser() . " draw ".$quantity." card";
        }
        if ($from == 'library' && $to == 'graveyard'){
            $message = $player->getUser() . " mills ".$quantity." card";
        }
        if ($from == 'library' && $to == 'exile'){
            $message = $player->getUser() . " exile ".$quantity." card";
        }
        return $message;
    }

    /**
     * @param $from
     * @param $to
     * @return null
     */
    public function getPictoMove($from, $to){
        // Draw
        if ($from == 'library' && $to == 'hand'){
            return '/images/planeswalkers/game-icons-net/faithtoken/card-draw.svg';
        }
        // Mills
        if ($from == 'library' && $to == 'graveyard'){
            return  '/images/planeswalkers/game-icons-net/delapouite/card-burn.svg';
        }
        // Exile
        if ($from == 'library' && $to == 'exile'){
            return '/images/planeswalkers/game-icons-net/delapouite/knocked-out-stars.svg';
        }
        return null;
    }

    /**
     * @Route("/planeswalkers/play/action/switch", name="planeswalkers.play.action.switch", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param MoveService $moveService
     * @param PlayerService $playerService
     * @return JsonResponse
     */
    public function switch(Request $request, PublisherInterface $publisher, MoveService $moveService, PlayerService $playerService){
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $action = null;
        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $opponent = $this->getDoctrine()->getRepository(Player::class)->find($datas['opponent']);
        $card = $this->getDoctrine()->getRepository(GameCardBattlefield::class)->find($datas['card']);
        $battlefield = $this->getDoctrine()->getRepository(Battlefield::class)->find($datas['battlefield']);

        // Ensemble des scénarios lors du déplacement d'une carte
        $moveService->switch($battlefield, $datas);
        $em->flush();

        // Publication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = [
            'action'        =>  'switch',
            'log'           =>  $opponent . " is now the controller of " . $card->getCard(),
            'picto'         =>  '/images/planeswalkers/game-icons-net/delapouite/switch-weapon.svg',
            'player'        =>  $player->getId(),
            'opponent'      =>  $opponent->getId(),
            'playerAreas'   =>  $playerService->areas($player),
            'opponentAreas' =>  $playerService->areas($opponent),
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}