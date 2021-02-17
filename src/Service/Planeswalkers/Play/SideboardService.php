<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Sideboard;
use App\Entity\Planeswalkers\Play\Player;

class SideboardService
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
     * @return Sideboard
     */
    public function new(Player $player): Sideboard
    {
        $sideboard = new Sideboard();
        $sideboard->setPlayer($player);

        $this->em->persist($sideboard);
        return $sideboard;
    }
}