<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Hand;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\Action\MoveService;

class HandService
{
    private $em;
    private $moveService;

    /**
     * @param EntityManagerInterface $em
     * @param MoveService $moveService
     */
    public function __construct(EntityManagerInterface $em, MoveService $moveService)
    {
        $this->em = $em;
        $this->moveService = $moveService;
    }

    /**
     * @param Player $player
     * @return Hand
     */
    public function new(Player $player): Hand
    {
        $hand = new Hand();
        $hand->setPlayer($player);

        // Pioche 7 cartes dans library au début d'une partie
        $this->moveService->draw($player, 7);

        $this->em->persist($hand);
        return $hand;
    }

}