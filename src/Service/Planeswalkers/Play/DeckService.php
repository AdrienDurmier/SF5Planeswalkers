<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Planeswalkers\APIScryfall;
use App\Service\Planeswalkers\CardService;
use App\Entity\Planeswalkers\Deck;
use App\Entity\User;
use App\Entity\Planeswalkers\DeckCard;

class DeckService
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
     * @param User $user
     * @param array $datas
     * @return Deck
     */
    public function new(User $user, array $datas): Deck
    {
        $deck = new Deck();
        $deck->setTitle($datas['title']);
        $deck->setContent($datas['content']);
        $deck->setPublic(isset($datas['public'])?$datas['public']:0);
        $deck->setAuthor($user);
        $this->em->persist($deck);

        return $deck;
    }

    /**
     * @param Deck $deck
     * @param array $contentLines
     * @return Deck
     */
    public function import(Deck $deck, array $contentLines): Deck
    {
        $dansLeSideboard = false;
        foreach($contentLines as $line){
            if ($line == 'Deck' || $line == 'Sideboard' || $line == ''){
                if ($line == 'Sideboard'){
                    $dansLeSideboard = true;
                }
                if ($line == ''){
                    continue;
                }
            }
            else{
                // Séparation dans la ligne de la quantité et du nom de la carte
                list($quantity, $cardname) = explode(' ', $line, 2);

                // Création de la DeckCard
                $deckcard = new DeckCard();
                $response_card = $this->apiScryfall->interroger('get', 'cards/named?fuzzy='.$cardname);
                $card = $this->cardService->updateOrCreateCard($response_card);
                $deckcard->setCard($card);
                // Affectation en réserve
                if($dansLeSideboard){
                    $deckcard->setQuantiteReserve($quantity);
                }
                // Affectation dans le main deck
                else{
                    $deckcard->setQuantite($quantity);
                }
                $deckcard->setDeck($deck);
                $this->em->persist($deckcard);
            }
        }
        $this->em->persist($deck);
        return $deck;
    }

    /**
     * @param Deck $deck
     * @return array
     */
    public function export(Deck $deck): array
    {
        $deckContent = array();

        // Partie deck
        $deckContent[] = 'Deck';
        foreach($deck->getCards() as $deckcard){
            if($deckcard->getQuantite() > 0){
                $deckContent[] = $deckcard->getQuantite() . ' '. $deckcard->getCard()->getName();
            }
        }

        $deckContent[] = '';

        // Partie sideboard
        $deckContent[] = 'Sideboard';
        foreach($deck->getCards() as $deckcard){
            if($deckcard->getQuantiteReserve() > 0){
                $deckContent[] = $deckcard->getQuantiteReserve() . ' '. $deckcard->getCard()->getName();
            }
        }

        return $deckContent;
    }

}