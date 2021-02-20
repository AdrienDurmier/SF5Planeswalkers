<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Hand;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\Action\DrawService;

class HandService
{
    private $em;
    private $drawService;

    /**
     * @param EntityManagerInterface $em
     * @param DrawService $drawService
     */
    public function __construct(EntityManagerInterface $em, DrawService $drawService)
    {
        $this->em = $em;
        $this->drawService = $drawService;
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
        $this->drawService->draw($player, 7);

        $this->em->persist($hand);
        return $hand;
    }

}