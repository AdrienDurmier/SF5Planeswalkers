<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Battlefield;
use App\Entity\Planeswalkers\Play\Player;

class BattlefieldService
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
     * @return Battlefield
     */
    public function new(Player $player): Battlefield
    {
        $battlefield = new Battlefield();
        $battlefield->setPlayer($player);

        $this->em->persist($battlefield);
        return $battlefield;
    }
}