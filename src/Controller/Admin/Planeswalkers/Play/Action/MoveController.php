<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\Action\MoveService;
use App\Service\Planeswalkers\Play\ExileService;
use App\Service\Planeswalkers\Play\GraveyardService;
use App\Service\Planeswalkers\Play\LibraryService;
use App\Utils\Planeswalkers\Play\GameCardExileUtils;
use App\Utils\Planeswalkers\Play\GameCardGraveyardUtils;
use App\Utils\Planeswalkers\Play\GameCardLibraryUtils;
use App\Utils\Planeswalkers\Play\GameCardHandUtils;
use App\Utils\Planeswalkers\Play\GameCardBattlefieldUtils;

class MoveController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/move", name="planeswalkers.play.action.move", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @param MoveService $moveService
     * @param ExileService $exileService
     * @param GraveyardService $graveyardService
     * @param LibraryService $libraryService
     * @return JsonResponse
     */
    public function move( Request $request, PublisherInterface $publisher, MoveService $moveService, ExileService $exileService, GraveyardService $graveyardService, LibraryService $libraryService)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $action = null;
        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);

        // Scénarios
        // Scénario Draw: le joueur pioche une carte
        if ($datas['from'] == 'library' && $datas['to'] == 'hand'){
            $action = 'draw';
            $moveService->draw($player, 1);
        }
        // Scénario Discard: le joueur se defausse d'une carte
        if ($datas['from'] == 'hand' && $datas['to'] == 'graveyard'){
            $action = 'discard';
            $moveService->discard($player, $datas['card']);
        }
        // Scénario Bounce: une carte du champs de bataille est renvoyée dans la main
        if ($datas['from'] == 'battlefield' && $datas['to'] == 'hand'){
            $action = 'bounce';
        }

        $em->flush();

        // Réponse
        $gameCardsExile = array();
        if ($player->getExile()->getGameCardsExile()) {
            foreach ($player->getExile()->getGameCardsExile() as $gameCardExile) {
                $gameCardsExile[] = GameCardExileUtils::formatJson($gameCardExile);
            }
        }
        $gameCardsGraveyard = array();
        if ($player->getGraveyard()->getGameCardsGraveyard()) {
            foreach ($player->getGraveyard()->getGameCardsGraveyard() as $gameCardGraveyard) {
                $gameCardsGraveyard[] = GameCardGraveyardUtils::formatJson($gameCardGraveyard);
            }
        }
        $gameCardsLibrary = array();
        if ($player->getLibrary()->getGameCardsLibrary()) {
            foreach ($player->getLibrary()->getGameCardsLibrary() as $gameCardLibrary) {
                $gameCardsLibrary[] = GameCardLibraryUtils::formatJson($gameCardLibrary);
            }
        }
        $gameCardsHand = array();
        if ($player->getHand()->getGameCardsHand()) {
            foreach ($player->getHand()->getGameCardsHand() as $gameCardHand) {
                $gameCardsHand[] = GameCardHandUtils::formatJson($gameCardHand);
            }
        }
        $gameCardsBattlefield = array();
        if ($player->getBattlefield()->getGameCardsBattlefield()){
            foreach ($player->getBattlefield()->getGameCardsBattlefield() as $gameCardBattlefield){
                $gameCardsBattlefield[] = GameCardBattlefieldUtils::formatJson($gameCardBattlefield);
            }
        }

        // Plublication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = json_encode([
            'action'       =>  $action,
            'player'       =>  $datas['player'],
            'exile'        =>  [
                'count'    =>  $player->getExile()->countGameCardsExile(),
                'cards'    =>  $gameCardsExile,
                'topCard'  =>  GameCardExileUtils::formatJson($exileService->topCard($player->getExile())),
            ],
            'graveyard'    =>  [
                'count'    =>  $player->getGraveyard()->countGameCardsGraveyard(),
                'cards'    =>  $gameCardsGraveyard,
                'topCard'  =>  GameCardGraveyardUtils::formatJson($graveyardService->topCard($player->getGraveyard())),
            ],
            'library'      =>  [
                'count'    =>  $player->getLibrary()->countGameCardsLibrary(),
                'cards'    =>  $gameCardsLibrary,
                'topCard'  =>  GameCardLibraryUtils::formatJson($libraryService->topCard($player->getLibrary())),
            ],
            'hand'         =>  [
                'count'    =>  $player->getHand()->countGameCardsHand(),
                'cards'    =>  $gameCardsHand,
            ],
            'battlefield'  =>  [
                'count'    =>  $player->getBattlefield()->countGameCardsBattlefield(),
                'cards'    =>  $gameCardsBattlefield,
            ],
        ]);

        $update = new Update($topic, $datasMercure);
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}