<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\DeckCard;
use App\Service\Planeswalkers\CardService;
use App\Service\Planeswalkers\APIScryfall;

class DeckCardController extends AbstractController
{
    /**
     * @Route("/planeswalkers/deckcard/new", name="planeswalkers.deckcard.new")
     * @param APIScryfall $apiScryfall
     * @param CardService $cardService
     * @param Request $request
     * @return Response
     */
    public function new(APIScryfall $apiScryfall, CardService $cardService, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $datas = $request->request->all();
            // Création de la card en local
            $deck = $this->getDoctrine()->getRepository(Deck::class)->find($datas['deck']);
            $deckcard = null;
            foreach($deck->getCards() as $deck_card){
                if($deck_card->getCard()->getIdScryfall() == $datas['id_scryfall']){
                    $deckcard = $deck_card;
                }
            }
            if($deckcard === null){
                $deckcard = new DeckCard();
                $response_card = $apiScryfall->interroger('get', 'cards/'.$datas['id_scryfall']);
                $card = $cardService->updateOrCreateCard($response_card);
                $deckcard->setCard($card);
            }
            if(isset($datas['reserve'])){
                $quantite = $deckcard->getQuantiteReserve() + $datas['quantite'];
                $deckcard->setQuantiteReserve($quantite);
            }else{
                $quantite = $deckcard->getQuantite() + $datas['quantite'];
                $deckcard->setQuantite($quantite);
            }
            $deckcard->setDeck($deck);
            $em->persist($deckcard);
            $em->flush();
            return $this->redirectToRoute('planeswalkers.deck.edit', [
                'id' => $deck->getId()
            ]);
        }

        return $this->render('admin/planeswalkers/deck/new.html.twig', [
        ]);
    }

    /**
     * @Route("/planeswalkers/deckcard/ajax-quantite", name="planeswalkers.deckcard.ajax.quantite", methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxQuantite(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $delete = false;
        $deckcard = $this->getDoctrine()->getRepository(DeckCard::class)->find($datas['deckcard']);
        if(isset($datas['quantite'])){
            if($datas['quantite'] > 1) {
                $deckcard->setQuantite($datas['quantite']);
                $em->persist($deckcard);
            } else {
                $em->remove($deckcard);
                $delete = true;
            }
            $em->flush();
        }
        $em->flush();
        $response = array(
            'delete' => $delete,
        );
        return new JsonResponse($response);
    }


}