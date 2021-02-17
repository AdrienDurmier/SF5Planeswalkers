<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Hand;
use App\Entity\Planeswalkers\Play\Player;

class HandService
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
     * @return Hand
     */
    public function new(Player $player): Hand
    {
        $hand = new Hand();
        $hand->setPlayer($player);

        // Pioche 7 cartes de la librairie par défaut

        $this->em->persist($hand);
        return $hand;
    }
}