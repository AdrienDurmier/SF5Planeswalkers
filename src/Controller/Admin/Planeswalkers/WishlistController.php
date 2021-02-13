<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\ServerException;
use App\Service\Planeswalkers\LegalityService;
use App\Service\Planeswalkers\APIScryfall;
use App\Service\Planeswalkers\ProbabilityService;
use App\Entity\Planeswalkers\Wishlist;
use App\Entity\Planeswalkers\WishlistCard;
use Unirest\Exception;

class WishlistController extends AbstractController
{
    /**
     * @Route("/planeswalkers/wishlists", name="planeswalkers.wishlist.index")
     * @return Response
     */
    public function index()
    {
        $wishlists = $this->getDoctrine()->getRepository(Wishlist::class)->findBy([
            'author' => $this->getUser()
        ]);

        return $this->render('admin/planeswalkers/wishlist/index.html.twig', [
            'wishlists'  =>  $wishlists
        ]);
    }

    /**
     * @Route("/admin/planeswalkers/wishlists/new", name="planeswalkers.wishlist.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $datas = $request->request->all();
            $wishlist = new Wishlist();
            $wishlist->setTitle($datas['title']);
            $wishlist->setAuthor($this->getUser());
            $em->persist($wishlist);
            $em->flush();
            return $this->redirectToRoute('planeswalkers.wishlist.index');
        }

        return $this->render('admin/planeswalkers/wishlist/new.html.twig', [
        ]);
    }

    /**
     * @Route("/admin/planeswalkers/wishlists/{id}", name="planeswalkers.wishlist.edit", methods="GET|POST")
     * @return Response
     * @throws ServerException
     */
    public function edit(Wishlist $wishlist)
    {
        $wishlist_ordered = [
            'Creatures' => [],
            'Planeswalkers' => [],
            'Spells' => [],
            'Lands' => [],
        ];
        foreach ($wishlist->getCards() as $wishlist_card){
            if(strpos(strtolower($wishlist_card->getCard()->getTypeLine()), 'creature') !== false){
                $wishlist_ordered['Creatures'][] = $wishlist_card;
            }
            else if(strpos(strtolower($wishlist_card->getCard()->getTypeLine()), 'planeswalker') !== false){
                $wishlist_ordered['Planeswalkers'][] = $wishlist_card;
            }
            else if(strpos(strtolower($wishlist_card->getCard()->getTypeLine()), 'land') !== false){
                $wishlist_ordered['Lands'][] = $wishlist_card;
            }else{
                $wishlist_ordered['Spells'][] = $wishlist_card;
            }
        }

        return $this->render('admin/planeswalkers/wishlist/edit.html.twig', [
            'wishlist'          =>  $wishlist,
            'wishlist_ordered'  =>  $wishlist_ordered,
        ]);
    }

    /**
     * @Route("/planeswalkers/wishlists/{id}", name="planeswalkers.wishlist.delete", methods="DELETE")
     * @param Wishlist $wishlist
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Wishlist $wishlist, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($this->isCsrfTokenValid('delete_wishlist', $request->get('_token'))){
            $em->remove($wishlist);
            $em->flush();
            $this->addFlash('success', "Wishlist supprimé avec succès");
        }
        return $this->redirectToRoute('planeswalkers.wishlist.index');
    }

}