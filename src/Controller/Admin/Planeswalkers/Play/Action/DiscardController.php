<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\Action\DiscardService;
use App\Service\Planeswalkers\Play\GraveyardService;
use App\Utils\Planeswalkers\Play\GameCardGraveyardUtils;
use App\Utils\Planeswalkers\Play\GameCardHandUtils;

class DiscardController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/discard", name="planeswalkers.play.action.discard", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param DiscardService $discardService
     * @param GraveyardService $graveyardService
     * @return JsonResponse
     */
    public function discard(Request $request, PublisherInterface $publisher, DiscardService $discardService, GraveyardService $graveyardService)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();

        // Action
        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);
        $discardService->discard($player, $datas['card']);
        $em->flush();

        // Réponse
        $gameCardsGraveyard = array();
        foreach ($player->getGraveyard()->getGameCardsGraveyard() as $gameCardGraveyard){
            $gameCardsGraveyard[] = GameCardGraveyardUtils::formatJson($gameCardGraveyard);
        }
        $gameCardsHand = array();
        foreach ($player->getHand()->getGameCardsHand() as $gameCardHand){
            $gameCardsHand[] = GameCardHandUtils::formatJson($gameCardHand);
        }

        // Plublication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = json_encode([
            'action'       =>  'discard',
            'player'       =>  $datas['player'],
            'graveyard'    =>  [
                'count'    =>  $player->getGraveyard()->countGameCardsGraveyard(),
                'cards'     =>  $gameCardsGraveyard,
                'topCard'  =>  [
                    'idScryfall'    => $graveyardService->topCard($player->getGraveyard())->getCard()->getIdScryfall(),
                    'imageUrisPng'  => $graveyardService->topCard($player->getGraveyard())->getCard()->getImageUrisPng(),
                ],
            ],
            'hand'    =>  [
                'count'    =>  $player->getHand()->countGameCardsHand(),
                'cards'     =>  $gameCardsHand,
            ],
        ]);

        $update = new Update($topic, $datasMercure);
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}