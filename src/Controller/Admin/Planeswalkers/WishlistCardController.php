<?php

namespace App\Controller\Admin\Planeswalkers;

use App\Entity\Planeswalkers\Wishlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Unirest\Exception;
use App\Entity\Planeswalkers\Card;
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\WishlistCard;
use App\Service\Planeswalkers\APIScryfall;

class WishlistCardController extends AbstractController
{
    /**
     * @Route("/planeswalkers/wishlistcard/new", name="planeswalkers.wishlistcard.new", methods="POST")
     * @param APIScryfall $apiScryfall
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(APIScryfall $apiScryfall, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        // Création de la card en local
        $wishlist = $this->getDoctrine()->getRepository(Wishlist::class)->find($datas['wishlist']);
        $response_card = $apiScryfall->interroger('get', 'cards/'.$datas['id_scryfall']);
        $wishlistcard = null;
        foreach($wishlist->getCards() as $wishlist_card){
            if($wishlist_card->getCard()->getIdScryfall() == $datas['id_scryfall']){
                $wishlistcard = $wishlist_card;
            }
        }
        if($wishlistcard === null){
            $wishlistcard = new WishlistCard();
            $card = $this->getDoctrine()->getRepository(Card::class)->findOneByIdScryfall($response_card->body->id);
            if ($card == null){
                $card = new Card(); // todo créer un CardService pour créer ou mettre à jour une carte
            }
            $card->setIdScryfall($response_card->body->id);
            $card->setName($response_card->body->name);
            $card->setLayout($response_card->body->layout);
            $card->setImageUrisSmall($response_card->body->image_uris->small);
            $card->setImageUrisNormal($response_card->body->image_uris->normal);
            $card->setImageUrisLarge($response_card->body->image_uris->large);
            $card->setImageUrisPng($response_card->body->image_uris->png);
            $card->setImageUrisArtCrop($response_card->body->image_uris->art_crop);
            $card->setManaCost($response_card->body->mana_cost);
            $card->setCmc($response_card->body->cmc);
            $card->setTypeLine($response_card->body->type_line);
            $card->setRarity($response_card->body->rarity);
            $card->setColors($response_card->body->colors);
            $em->persist($card);
            $em->flush();
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

}