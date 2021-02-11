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
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\DeckCard;
use Unirest\Exception;

class DeckController extends AbstractController
{
    /**
     * @Route("/planeswalkers/decks", name="planeswalkers.deck.index")
     * @param APIScryfall $apiScryfall
     * @return Response
     */
    public function index(APIScryfall $apiScryfall)
    {
        $decks = $this->getDoctrine()->getRepository(Deck::class)->findBy([
            'author' => $this->getUser()
        ]);

        return $this->render('admin/planeswalkers/deck/index.html.twig', [
            'decks'  =>  $decks
        ]);
    }

    /**
     * @Route("/admin/planeswalkers/decks/new", name="planeswalkers.deck.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $datas = $request->request->all();
            $deck = new Deck();
            $deck->setTitle($datas['title']);
            $deck->setContent($datas['content']);
            $deck->setPublic(isset($datas['public'])?$datas['public']:0);
            $deck->setAuthor($this->getUser());
            $em->persist($deck);
            $em->flush();
            return $this->redirectToRoute('planeswalkers.deck.edit', [
                'id' => $deck->getId()
            ]);
        }

        return $this->render('admin/planeswalkers/deck/new.html.twig', [
        ]);
    }

    /**
     * @Route("/planeswalkers/decks/{id}", name="planeswalkers.deck.edit", methods="GET|POST")
     * @return Response
     * @throws ServerException
     */
    public function edit(Deck $deck)
    {
        $deck_ordered = [
            'Creatures' => [],
            'Planeswalkers' => [],
            'Spells' => [],
            'Lands' => [],
        ];
        foreach ($deck->getCards() as $deck_card){
            if(strpos(strtolower($deck_card->getCard()->getTypeLine()), 'creature') !== false){
                $deck_ordered['Creatures'][] = $deck_card;
            }
            else if(strpos(strtolower($deck_card->getCard()->getTypeLine()), 'planeswalker') !== false){
                $deck_ordered['Planeswalkers'][] = $deck_card;
            }
            else if(strpos(strtolower($deck_card->getCard()->getTypeLine()), 'land') !== false){
                $deck_ordered['Lands'][] = $deck_card;
            }else{
                $deck_ordered['Spells'][] = $deck_card;
            }
        }

        return $this->render('admin/planeswalkers/deck/edit.html.twig', [
            'deck'         =>  $deck,
            'deck_ordered'   =>  $deck_ordered,
        ]);
    }

    /**
     * @Route("/planeswalkers/decks/{id}", name="planeswalkers.deck.delete", methods="DELETE")
     * @param Deck $deck
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Deck $deck, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($this->isCsrfTokenValid('delete_deck', $request->get('_token'))){
            $em->remove($deck);
            $em->flush();
            $this->addFlash('success', "Deck supprimé avec succès");
        }
        return $this->redirectToRoute('planeswalkers.deck.index');
    }

    /**
     * @Route("/planeswalkers/decks-legality/{id}", name="planeswalkers.deck.legality")
     * @param Deck $deck
     * @param LegalityService $legalityService
     * @return Response
     * @throws ServerException
     */
    public function legality(Deck $deck, LegalityService $legalityService)
    {
        $deck_cards = $this->getDoctrine()->getRepository(DeckCard::class)->findByDeck($deck);
        $legalities_deck = $legalityService->deck($deck_cards);
        $legalities_cartes = $legalityService->cards($deck_cards);

        return $this->render('admin/planeswalkers/deck/legality.html.twig', [
            'deck'         =>  $deck,
            'legalities_deck'   =>  $legalities_deck,
            'legalities_cartes'   =>  $legalities_cartes,
        ]);
    }

    /**
     * @Route("/planeswalkers/decks-estimation/{id}", name="planeswalkers.deck.estimation")
     * @param Deck $deck
     * @param APIScryfall $apiScryfall
     * @return Response
     * @throws Exception
     */
    public function estimation(Deck $deck, APIScryfall $apiScryfall)
    {
        $deck_cards = $this->getDoctrine()->getRepository(DeckCard::class)->findByDeck($deck);

        $estimation = [];
        $total = 0;
        $total_main = 0;
        $total_reserve = 0;
        foreach($deck_cards as $deck_card){
            $response_card = $apiScryfall->interroger('get', 'cards/'.$deck_card->getCard()->getIdScryfall());
            $total_carte_main = $deck_card->getQuantite() * $response_card->body->prices->eur;
            $total_carte_reserve = $deck_card->getQuantiteReserve() * $response_card->body->prices->eur;
            $total_main += $total_carte_main;
            $total_reserve += $total_carte_reserve;
            $total += $total_carte_main + $total_carte_reserve;
            // carte
            $estimation['cartes'][$deck_card->getCard()->getId()]['carte'] = $response_card->body;
            $estimation['cartes'][$deck_card->getCard()->getId()]['quantite'] = $deck_card->getQuantite();
            $estimation['cartes'][$deck_card->getCard()->getId()]['quantite_reserve'] = $deck_card->getQuantiteReserve();
            $estimation['cartes'][$deck_card->getCard()->getId()]['total_carte_main'] = $total_carte_main;
            $estimation['cartes'][$deck_card->getCard()->getId()]['total_carte_reserve'] = $total_carte_reserve;
            // total
            $estimation['deck']['total'] = $total;
            $estimation['deck']['total_main'] = $total_main;
            $estimation['deck']['total_reserve'] = $total_reserve;
        }

        return $this->render('admin/planeswalkers/deck/estimation.html.twig', [
            'deck'         =>  $deck,
            'estimation'   =>  $estimation,
        ]);
    }

    /**
     * @Route("/planeswalkers/decks-probabilites/{id}", name="planeswalkers.deck.probabilites")
     * @param Deck $deck
     * @param ProbabilityService $probabilityService
     * @return Response
     */
    public function probabilites(Deck $deck, ProbabilityService $probabilityService)
    {
        $deck_cards = $this->getDoctrine()->getRepository(DeckCard::class)->findByDeck($deck);
        $probabilites = $probabilityService->tirageParTour($deck, $deck_cards);

        return $this->render('admin/planeswalkers/deck/probabilites.html.twig', [
            'deck'         =>  $deck,
            'probabilites' =>  $probabilites,
        ]);
    }

    /**
     * @Route("/planeswalkers/deck/ajax-maindepart", name="planeswalkers.deck.ajax.maindepart", methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxMainDepart(Request $request)
    {
        $datas = $request->request->all();
        $deck = $this->getDoctrine()->getRepository(Deck::class)->find($datas['deck']);

        $response = array(
            'bibliotheque' => $deck->getMainDepart(),
        );
        return new JsonResponse($response);
    }

}