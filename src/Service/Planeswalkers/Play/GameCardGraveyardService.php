<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\GameCardGraveyard;
use App\Entity\Planeswalkers\Card;

class GameCardGraveyardService
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
     * @return GameCardGraveyard
     */
    public function new(Card $card, int $weight): GameCardGraveyard
    {
        $gameCard = new GameCardGraveyard();
        $gameCard->setCard($card);
        $gameCard->setWeight($weight);

        $this->em->persist($gameCard);
        return $gameCard;
    }
}