<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planeswalkers\CollectionCard;
use App\Entity\Planeswalkers\Collection;
use App\Service\Planeswalkers\APIScryfall;
use App\Service\Planeswalkers\CardService;

class CollectionCardController extends AbstractController
{
    /**
     * @Route("/planeswalkers/collectioncard/new", name="planeswalkers.collectioncard.new", methods="POST")
     * @param APIScryfall $apiScryfall
     * @param CardService $cardService
     * @param Request $request
     * @return Response
     */
    public function new(APIScryfall $apiScryfall, CardService $cardService, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $collection = $this->getDoctrine()->getRepository(Collection::class)->findOneBy([
            'author' => $this->getUser()
        ]);

        if (!$collection) {
            // Création de l'utilisateur sur Apps
            $collection = new Collection();
            $collection->setAuthor($this->getUser());
            $em->persist($collection);
        }

        // Création de la card en local
        $collectioncard = null;
        if ($collection->getCards()){
            foreach($collection->getCards() as $collection_card){
                if($collection_card->getCard()->getIdScryfall() == $datas['id_scryfall']){
                    $collectioncard = $collection_card;
                }
            }
        }
        if($collectioncard === null){
            $collectioncard = new CollectionCard();
            $response_card = $apiScryfall->interroger('get', 'cards/'.$datas['id_scryfall']);
            $card = $cardService->updateOrCreateCard($response_card);
            $em->persist($card);
            $collectioncard->setCard($card);
        }
        $quantite = $collectioncard->getQuantite() + $datas['quantite'];
        $collectioncard->setQuantite($quantite);
        $collectioncard->setCollection($collection);
        $em->persist($collectioncard);
        $em->flush();

        return $this->redirectToRoute('planeswalkers.collection.index');
    }

    /**
     * @Route("/planeswalkers/collectioncard/ajax-quantite", name="planeswalkers.collectioncard.ajax.quantite", methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxQuantite(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $request->request->all();
        $delete = false;
        $collectioncard = $this->getDoctrine()->getRepository(CollectionCard::class)->find($datas['collectioncard']);
        if(isset($datas['quantite'])){
            if($datas['quantite'] > 1) {
                $collectioncard->setQuantite($datas['quantite']);
                $em->persist($collectioncard);
            } else {
                $em->remove($collectioncard);
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