<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\ServerException;
use App\Entity\Planeswalkers\Collection;

class CollectionController extends AbstractController
{
    /**
     * @Route("/admin/planeswalkers/collection", name="planeswalkers.collection.index", methods="GET|POST")
     * @return Response
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $collection = $this->getDoctrine()->getRepository(Collection::class)->findOneBy([
           'author' => $this->getUser()
        ]);

        if (!$collection) {
            // Création de l'utilisateur sur Apps
            $collection = new Collection();
            $collection->setAuthor($this->getUser());
            $em->persist($collection);
            $em->flush();
        }

        $collection_ordered = [
            'Creatures' => [],
            'Planeswalkers' => [],
            'Spells' => [],
            'Lands' => [],
        ];
        if ($collection->getCards()){
            foreach ($collection->getCards() as $collection_card){
                if(strpos(strtolower($collection_card->getCard()->getTypeLine()), 'creature') !== false){
                    $collection_ordered['Creatures'][] = $collection_card;
                }
                else if(strpos(strtolower($collection_card->getCard()->getTypeLine()), 'planeswalker') !== false){
                    $collection_ordered['Planeswalkers'][] = $collection_card;
                }
                else if(strpos(strtolower($collection_card->getCard()->getTypeLine()), 'land') !== false){
                    $collection_ordered['Lands'][] = $collection_card;
                }else{
                    $collection_ordered['Spells'][] = $collection_card;
                }
            }
        }

        return $this->render('admin/planeswalkers/collection/index.html.twig', [
            'collection'          =>  $collection,
            'collection_ordered'  =>  $collection_ordered,
        ]);
    }

}