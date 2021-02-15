<?php

namespace App\Service\Planeswalkers\Play;

use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\Legality;
use App\Entity\Planeswalkers\Play\Game;
use App\Entity\Planeswalkers\Play\Player;
use Doctrine\ORM\EntityManagerInterface;
use Datetime;
use Exception;
use App\Entity\User;
use App\Utils\Jwt;

class GameService
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
     * @param array $datas
     * @param User $user
     * @return Game
     */
    public function new(array $datas, User $user): Game
    {
        $deck = $this->em->getRepository(Deck::class)->find($datas['deck']);
        $legality = $this->em->getRepository(Legality::class)->find($datas['format']);

        $game = new Game();

        // Author
        $game->setAuthor($user);

        // Legality
        $game->setLegality($legality);

        $this->em->persist($game);

        // Players
        $player = new Player();
        $player->setUser($user);
        $player->setGame($game);
        $player->setDeck($deck);
        $this->em->persist($player);
        $game->addPlayer($player);

        // Save
        $this->em->persist($game);
        $this->em->flush();

        return $game;
    }
}