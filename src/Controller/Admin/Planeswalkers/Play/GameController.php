<?php

namespace App\Controller\Admin\Planeswalkers\Play;

use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\Legality;
use App\Entity\Planeswalkers\Play\Game;
use App\Service\Planeswalkers\Play\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/games", name="planeswalkers.play.game.index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $games = $this->getDoctrine()->getRepository(Game::class)->findAll();
        $decks = $this->getDoctrine()->getRepository(Deck::class)->findByAuthor($this->getUser());
        $formats = $this->getDoctrine()->getRepository(Legality::class)->findAll();

        return $this->render('admin/planeswalkers/play/game/index.html.twig', [
            'games'     =>  $games,
            'decks'     =>  $decks,
            'formats'   =>  $formats,
        ]);
    }

    /**
     * @Route("/admin/planeswalkers/play/games/new", name="planeswalkers.play.game.new", methods="POST")
     * @param GameService $gameService
     * @param Request $request
     * @return Response
     */
    public function new(GameService $gameService, Request $request)
    {
        $datas = $request->request->all();
        $gameService->new($datas, $this->getUser());

        return $this->redirectToRoute('planeswalkers.play.game.index');
    }

    /**
     * @Route("/admin/planeswalkers/play/games/join", name="planeswalkers.play.game.join", methods="POST")
     * @param GameService $gameService
     * @param Request $request
     * @return Response
     */
    public function join(GameService $gameService, Request $request)
    {
        $datas = $request->request->all();
        $game = $gameService->join($datas, $this->getUser());

        return $this->redirectToRoute('planeswalkers.play.game.fight', [
            'id'  =>  $game->getId(),
        ]);
    }

    /**
     * @Route("/admin/planeswalkers/play/games/fight/{id}", name="planeswalkers.play.game.fight")
     * @param Game $game
     * @param GameService $gameService
     * @param Request $request
     * @return Response
     */
    public function fight(Game $game, GameService $gameService, Request $request)
    {
        $player = $game->getPlayer($this->getUser());
        $opponent = $game->getOpponent($this->getUser());

        return $this->render('admin/planeswalkers/play/game/fight.html.twig', [
            'game'      =>  $game,
            'player'    =>  $player,
            'opponent'  =>  $opponent,
        ]);
    }
    
}