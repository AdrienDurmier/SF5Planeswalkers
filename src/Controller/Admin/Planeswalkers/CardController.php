<?php

namespace App\Controller\Admin\Planeswalkers;

use App\Entity\Planeswalkers\Deck;
use Doctrine\DBAL\Exception\ServerException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\APIScryfall;

class CardController extends AbstractController
{
    /**
     * @Route("/planeswalkers/cards/search", name="planeswalkers.card.search", methods="GET")
     * @param APIScryfall $apiScryfall
     * @param Request $request
     * @return JsonResponse
     * @throws ServerException
     */
    public function search(APIScryfall $apiScryfall, Request $request) {
        $params = $request->query->all();

        $response_card = $apiScryfall->interroger('get', 'cards/search?q=name%3A'.$params['term']);

        $response = array(
            'cards' => $response_card->body
        );

        return new JsonResponse($response);
    }


    /**
     * @Route("/planeswalkers/cards/{id}", name="planeswalkers.card.show")
     * @param APIScryfall $apiScryfall
     * @return Response
     * @throws ServerException
     */
    public function show($id, APIScryfall $apiScryfall)
    {
        $response_card = $apiScryfall->interroger('get', 'cards/'.$id);
        $response_rules = $apiScryfall->interroger('get', 'cards/'.$id.'/rulings');

        $decks = $this->getDoctrine()->getRepository(Deck::class)->findAll();

        return $this->render('planeswalkers/card/show.html.twig', [
            'card'      =>  $response_card->body,
            'rules'     =>  $response_rules->body,
            'decks'     =>  $decks,
        ]);
    }
    
}