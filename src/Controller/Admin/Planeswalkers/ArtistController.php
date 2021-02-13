<?php

namespace App\Controller\Admin\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\Planeswalkers\APIScryfall;

class ArtistController extends AbstractController
{
    /**
     * @Route("/planeswalkers/artists", name="planeswalkers.artist.index")
     * @param PaginatorInterface $paginator
     * @param APIScryfall $apiScryfall
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, APIScryfall $apiScryfall, Request $request)
    {
        $response = $apiScryfall->interroger('get', 'catalog/artist-names');

        $artists = $paginator->paginate(
            $response->body->data,
            $request->query->getInt('page', 1),
            180
        );

        return $this->render('admin/planeswalkers/artist/index.html.twig', [
            'artists'  =>  $artists,
        ]);
    }

    /**
     * @Route("/planeswalkers/artists/{artist}", name="planeswalkers.artist.show")
     * @param string $artist
     * @param PaginatorInterface $paginator
     * @param APIScryfall $apiScryfall
     * @param Request $request
     * @return Response
     */
    public function show(string $artist, PaginatorInterface $paginator, APIScryfall $apiScryfall, Request $request)
    {
        $query = $request->query->all();
        $response = $apiScryfall->interroger('get', 'cards/search?q=a%3A"'.$artist.'"');

        $cards = $paginator->paginate(
            $response->body->data,
            $request->query->getInt('page', 1),
            24
        );

        return $this->render('admin/planeswalkers/artist/show.html.twig', [
            'name'  =>  $query['name'],
            'cards'  =>  $cards,
        ]);
    }
    
}