<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Graveyard;
use App\Entity\Planeswalkers\Play\Player;

class GraveyardService
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
     * @return Graveyard
     */
    public function new(Player $player): Graveyard
    {
        $graveyard = new Graveyard();
        $graveyard->setPlayer($player);

        $this->em->persist($graveyard);
        return $graveyard;
    }
}