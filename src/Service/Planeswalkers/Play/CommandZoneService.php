<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\CommandZone;
use App\Entity\Planeswalkers\Play\Player;

class CommandZoneService
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
     * @return CommandZone
     */
    public function new(Player $player): CommandZone
    {
        $commandZone = new CommandZone();
        $commandZone->setPlayer($player);

        $this->em->persist($commandZone);
        return $commandZone;
    }
}