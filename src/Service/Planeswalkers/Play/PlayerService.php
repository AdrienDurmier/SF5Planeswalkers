<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Planeswalkers\Play\Game;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Deck;
use App\Entity\User;

class PlayerService
{
    private $em;
    private $libraryService;
    private $handService;
    private $battlefieldService;
    private $commandZoneService;
    private $graveyardService;
    private $exileService;
    private $sideboardService;

    /**
     * @param EntityManagerInterface $em
     * @param LibraryService $libraryService
     * @param HandService $handService
     * @param BattlefieldService $battlefieldService
     * @param CommandZoneService $commandZoneService
     * @param GraveyardService $graveyardService
     * @param ExileService $exileService
     * @param SideboardService $sideboardService
     */
    public function __construct(EntityManagerInterface $em,
                                LibraryService $libraryService,
                                HandService $handService,
                                BattlefieldService $battlefieldService,
                                CommandZoneService $commandZoneService,
                                GraveyardService $graveyardService,
                                ExileService $exileService,
                                SideboardService $sideboardService)
    {
        $this->em = $em;
        $this->libraryService = $libraryService;
        $this->handService = $handService;
        $this->battlefieldService = $battlefieldService;
        $this->commandZoneService = $commandZoneService;
        $this->graveyardService = $graveyardService;
        $this->exileService = $exileService;
        $this->sideboardService = $sideboardService;
    }

    /**
     * @param Game $game
     * @param User $user
     * @param Deck $deck
     * @return Player
     * @throws Exception
     */
    public function new(Game $game, User $user, Deck $deck): Player
    {
        $player = new Player();

        $player->setGame($game);
        $player->setUser($user);
        $player->setDeck($deck);
        $player->setLibrary($this->libraryService->new($player));
        $player->setHand($this->handService->new($player));
        $player->setBattlefield($this->battlefieldService->new($player));
        $player->setCommandZone($this->commandZoneService->new($player));
        $player->setGraveyard($this->graveyardService->new($player));
        $player->setExile($this->exileService->new($player));
        $player->setSideboard($this->sideboardService->new($player));

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

}