<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Game;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Deck;
use App\Entity\User;

class PlayerService
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
     * @param Game $game
     * @param User $user
     * @param Deck $deck
     * @return Game
     */
    public function new(Game $game, User $user, Deck $deck): Player
    {
        $player = new Player();
        $player->setGame($game);
        $player->setUser($user);
        $player->setDeck($deck);
        $this->em->persist($player);
        return $player;
    }
}