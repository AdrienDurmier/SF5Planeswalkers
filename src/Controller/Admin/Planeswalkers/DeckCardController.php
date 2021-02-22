<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\DeckCard;
use App\Service\Planeswalkers\Play\DeckCardService;

class DeckCardController extends AbstractController
{
    /**
     * @Route("/planeswalkers/deckcard/new", name="planeswalkers.deckcard.new")
     * @param DeckCardService $deckCardService
     * @param Request $request
     * @return Response
     */
    public function new(DeckCardService $deckCardService, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $datas = $request->request->all();
            $deck = $this->getDoctrine()->getRepository(Deck::class)->find($datas['deck']);
            // Création de la card en local
            $deckCardService->new($deck, $datas);
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