<?php

namespace App\Service\Planeswalkers\Play;

use App\Service\Planeswalkers\APIScryfall;
use App\Service\Planeswalkers\CardService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\DeckCard;
use App\Entity\Planeswalkers\Deck;

class DeckCardService
{
    private $em;
    private $apiScryfall;
    private $cardService;

    /**
     * @param EntityManagerInterface $em
     * @param APIScryfall $apiScryfall
     * @param CardService $cardService
     */
    public function __construct(EntityManagerInterface $em, APIScryfall $apiScryfall, CardService $cardService)
    {
        $this->em = $em;
        $this->apiScryfall = $apiScryfall;
        $this->cardService = $cardService;
    }

    /**
     * @param Deck $deck
     * @param array $datas
     * @return DeckCard
     */
    public function new(Deck $deck, array $datas): DeckCard
    {
        $deckcard = null;
        foreach($deck->getCards() as $deck_card){
            if($deck_card->getCard()->getIdScryfall() == $datas['id_scryfall']){
                $deckcard = $deck_card;
            }
        }
        if($deckcard === null){
            $deckcard = new DeckCard();
            $response_card = $this->apiScryfall->interroger('get', 'cards/'.$datas['id_scryfall']);
            $card = $this->cardService->updateOrCreateCard($response_card);
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
        $this->em->persist($deckcard);

        return $deckcard;
    }

}