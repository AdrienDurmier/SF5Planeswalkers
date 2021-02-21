<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Exile;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Play\GameCardExile;

class ExileService
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
     * @param Player $player
     * @return Exile
     */
    public function new(Player $player): Exile
    {
        $exile = new Exile();
        $exile->setPlayer($player);

        $this->em->persist($exile);
        return $exile;
    }

    /**
     * @param Exile $exile
     * @return GameCardExile|null
     */
    public function topCard(Exile $exile) : ?GameCardExile
    {
        foreach($exile->getGameCardsExile() as $gameCardsExile){
            if($gameCardsExile->getWeight() == $exile->countGameCardsExile()){
                return $gameCardsExile;
            }
        }
        return null;
    }
}