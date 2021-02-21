<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use App\Entity\Planeswalkers\Play\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Service\Planeswalkers\Play\Action\DrawService;

class DrawController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/draw", name="planeswalkers.play.action.draw", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param DrawService $drawService
     * @return JsonResponse
     */
    public function draw(Request $request, PublisherInterface $publisher, DrawService $drawService)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();

        // Action
        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $hand = $drawService->draw($player, $datas['quantity']);
        $em->flush();

        // Réponse
        $gameCardsHand = array();
        foreach ($hand->getGameCardsHand() as $gameCardHand){
            $gameCardsHand[] = [
                'id'            => $gameCardHand->getId(),
                'idScryfall'    => $gameCardHand->getCard()->getIdScryfall(),
                'imageUrisPng'  => $gameCardHand->getCard()->getImageUrisPng(),
            ];
        }

        // Plublication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = json_encode([
            'action'        =>  'draw',
            'player'        =>  $datas['player'],
            'library'       =>  [
                'count'  => $player->getLibrary()->countGameCardsLibrary(),
            ],
            'hand'       =>  [
                'count'  => $player->getHand()->countGameCardsHand(),
                'cards'  => $gameCardsHand,
            ],
        ]);
        $update = new Update($topic, $datasMercure);
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}