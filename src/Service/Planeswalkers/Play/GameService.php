<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\Legality;
use App\Entity\Planeswalkers\Play\Game;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\User;

class GameService
{
    private $em;
    private $playerService;

    /**
     * @param EntityManagerInterface $em
     * @param PlayerService $playerService
     */
    public function __construct(EntityManagerInterface $em, PlayerService $playerService)
    {
        $this->em = $em;
        $this->playerService = $playerService;
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

        // Entitées liées à game
        $this->em->persist($game);
        // Players
        $player = $this->playerService->new($game, $user, $deck);
        $game->addPlayer($player);

        // Save
        $this->em->persist($game);
        $this->em->flush();

        return $game;
    }
}