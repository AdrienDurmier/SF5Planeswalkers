<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\DeckCard;

class SimulationController extends AbstractController
{
    /**
     * @Route("/planeswalkers/simulation/index", name="planeswalkers.simulation.index")
     * @return Response
     */
    public function index()
    {
        $decks = $this->getDoctrine()->getRepository(Deck::class)->findBy([
            'author' => $this->getUser()
        ]);

        return $this->render('admin/planeswalkers/simulation/index.html.twig', [
            'decks'  =>  $decks
        ]);
    }

    /**
     * @Route("/planeswalkers/simulation/play", name="planeswalkers.simulation.play", methods="POST")
     * @param Request $request
     * @return Response
     */
    public function play(Request $request)
    {
        $datas = $request->request->all();
        $deck = $this->getDoctrine()->getRepository(Deck::class)->find($datas['deck']);
        $bibliotheque = $deck->getBibliotheque();

        return $this->render('admin/planeswalkers/simulation/play.html.twig', [
            'bibliotheque' => $bibliotheque,
        ]);
    }
    
}