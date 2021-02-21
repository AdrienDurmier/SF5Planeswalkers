<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\GameCardExile;
use App\Entity\Planeswalkers\Card;

class GameCardExileService
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
     * @return GameCardExile
     */
    public function new(Card $card, int $weight): GameCardExile
    {
        $gameCard = new GameCardExile();
        $gameCard->setCard($card);
        $gameCard->setWeight($weight);

        $this->em->persist($gameCard);
        return $gameCard;
    }
}