<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\GameCardHand;
use App\Entity\Planeswalkers\Card;

class GameCardHandService
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
     * @return GameCardHand
     */
    public function new(Card $card, int $weight): GameCardHand
    {
        $gameCard = new GameCardHand();
        $gameCard->setCard($card);
        $gameCard->setReveal(false);
        $gameCard->setWeight($weight);

        $this->em->persist($gameCard);
        return $gameCard;
    }
}