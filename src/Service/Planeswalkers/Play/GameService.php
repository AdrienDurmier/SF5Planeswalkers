<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\Legality;
use App\Entity\Planeswalkers\Play\Game;
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
     * New Game
     *
     * @param array $datas
     * @param User $user
     * @return Game
     * @throws Exception
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

    /**
     * Join a game
     *
     * @param array $datas
     * @param User $user
     * @return Game
     * @throws Exception
     */
    public function join(array $datas, User $user): Game
    {
        $game = $this->em->getRepository(Game::class)->find($datas['game']);
        $deck = $this->em->getRepository(Deck::class)->find($datas['deck']);

        // Players
        $player = $this->playerService->new($game, $user, $deck);
        $game->addPlayer($player);

        // Save
        $this->em->persist($game);
        $this->em->flush();

        return $game;
    }
}