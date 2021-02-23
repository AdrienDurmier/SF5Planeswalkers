<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\GameCardBattlefield;
use App\Entity\Planeswalkers\Card;

class GameCardBattlefieldService
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
     * @param array $datas
     * @return GameCardBattlefield
     */
    public function new(Card $card, array $datas): GameCardBattlefield
    {
        $gameCard = new GameCardBattlefield();
        $gameCard->setCard($card);
        $gameCard->setFaceDown(false);
        $gameCard->setCounter(null);
        $gameCard->setOffsetX($datas['offsetX']);
        $gameCard->setOffsetY($datas['offsetY']);

        $this->em->persist($gameCard);
        return $gameCard;
    }

}