<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planeswalkers\WishlistCard;
use App\Entity\Planeswalkers\Wishlist;
use App\Service\Planeswalkers\APIScryfall;
use App\Service\Planeswalkers\CardService;

class WishlistCardController extends AbstractController
{
    /**
     * @Route("/planeswalkers/wishlistcard/new", name="planeswalkers.wishlistcard.new", methods="POST")
     * @param APIScryfall $apiScryfall
     * @param CardService $cardService
     * @param Request $request
     * @return Response
     */
    public function new(APIScryfall $apiScryfall, CardService $cardService, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        // Création de la card en local
        $wishlist = $this->getDoctrine()->getRepository(Wishlist::class)->find($datas['wishlist']);
        $wishlistcard = null;
        foreach($wishlist->getCards() as $wishlist_card){
            if($wishlist_card->getCard()->getIdScryfall() == $datas['id_scryfall']){
                $wishlistcard = $wishlist_card;
            }
        }
        if($wishlistcard === null){
            $wishlistcard = new WishlistCard();
            $response_card = $apiScryfall->interroger('get', 'cards/'.$datas['id_scryfall']);
            $card = $cardService->updateOrCreateCard($response_card);
            $em->persist($card);
            $wishlistcard->setCard($card);
        }
        $quantite = $wishlistcard->getQuantite() + $datas['quantite'];
        $wishlistcard->setQuantite($quantite);
        $wishlistcard->setWishlist($wishlist);
        $em->persist($wishlistcard);
        $em->flush();

        return $this->redirectToRoute('planeswalkers.wishlist.edit', [
            'id' => $wishlist->getId(),
        ]);
    }

    /**
     * @Route("/planeswalkers/wishlistcard/ajax-quantite", name="planeswalkers.wishlistcard.ajax.quantite", methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxQuantite(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $delete = false;
        $wishlistcard = $this->getDoctrine()->getRepository(WishlistCard::class)->find($datas['wishlistcard']);
        if(isset($datas['quantite'])){
            if($datas['quantite'] > 1) {
                $wishlistcard->setQuantite($datas['quantite']);
                $em->persist($wishlistcard);
            } else {
                $em->remove($wishlistcard);
                $delete = true;
            }
        }
        $em->flush();
        $response = array(
            'delete' => $delete,
        );
        return new JsonResponse($response);
    }
}