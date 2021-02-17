<?php

namespace App\Service\Planeswalkers\Play;

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
}