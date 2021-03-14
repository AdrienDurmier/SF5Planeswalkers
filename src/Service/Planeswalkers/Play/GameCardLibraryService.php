<?php

namespace App\Service\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\Library;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\GameCardLibrary;
use App\Entity\Planeswalkers\Card;

class GameCardLibraryService
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Card $card
     * @param int $weight
     * @return GameCardLibrary
     */
    public function new(Card $card, int $weight): GameCardLibrary
    {
        $gameCard = new GameCardLibrary();
        $gameCard->setCard($card);
        $gameCard->setReveal(false);
        $gameCard->setWeight($weight);
        $this->em->persist($gameCard);
        return $gameCard;
    }

    /**
     * @param Card $card
     * @param Library $library
     * @return GameCardLibrary
     */
    public function newBottomLibrary(Card $card, Library $library): GameCardLibrary
    {
        // Création de la carte au pied de la library
        $gameCard = new GameCardLibrary();
        $gameCard->setCard($card);
        $gameCard->setReveal(false);
        $gameCard->setWeight(1);
        $this->em->persist($gameCard);

        // Chacune des autres cartes doit avoir son poids incrémenté
        foreach($library->getGameCardsLibrary() as $cardLibrary){
            $weight = $cardLibrary->getWeight();
            $cardLibrary->setWeight($weight+1);
            $this->em->persist($cardLibrary);
        }
        return $gameCard;
    }
}