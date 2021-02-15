<?php

namespace App\Controller\Admin\Planeswalkers\Play;

use App\Entity\Planeswalkers\Legality;
use App\Entity\Planeswalkers\Play\Game;
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
        $formats = $this->getDoctrine()->getRepository(Legality::class)->findAll();

        return $this->render('admin/planeswalkers/play/game/index.html.twig', [
            'games'     =>  $games,
            'formats'   =>  $formats,
        ]);
    }

    /**
     * @Route("/admin/planeswalkers/play/games/new", name="planeswalkers.play.game.new", methods="POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $game = new Game();
        $legality = $em->getRepository(Legality::class)->find($datas['format']);
        $game->setAuthor($this->getUser());
        $game->setLegality($legality);
        $em->persist($game);
        $em->flush();
        return $this->redirectToRoute('planeswalkers.play.game.index');
    }
    
}