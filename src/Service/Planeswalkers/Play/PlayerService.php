<?php

namespace App\Service\Planeswalkers\Play;

use App\Utils\Planeswalkers\Play\GameCardBattlefieldUtils;
use App\Utils\Planeswalkers\Play\GameCardExileUtils;
use App\Utils\Planeswalkers\Play\GameCardGraveyardUtils;
use App\Utils\Planeswalkers\Play\GameCardHandUtils;
use App\Utils\Planeswalkers\Play\GameCardLibraryUtils;
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

    public function areas(Player $player): array
    {
        $gameCardsExile = array();
        if ($player->getExile()->getGameCardsExile()) {
            foreach ($player->getExile()->getGameCardsExile() as $gameCardExile) {
                $gameCardsExile[] = GameCardExileUtils::formatJson($gameCardExile);
            }
        }
        $gameCardsGraveyard = array();
        if ($player->getGraveyard()->getGameCardsGraveyard()) {
            foreach ($player->getGraveyard()->getGameCardsGraveyard() as $gameCardGraveyard) {
                $gameCardsGraveyard[] = GameCardGraveyardUtils::formatJson($gameCardGraveyard);
            }
        }
        $gameCardsLibrary = array();
        if ($player->getLibrary()->getGameCardsLibrary()) {
            foreach ($player->getLibrary()->getGameCardsLibrary() as $gameCardLibrary) {
                $gameCardsLibrary[] = GameCardLibraryUtils::formatJson($gameCardLibrary);
            }
        }
        $gameCardsHand = array();
        if ($player->getHand()->getGameCardsHand()) {
            foreach ($player->getHand()->getGameCardsHand() as $gameCardHand) {
                $gameCardsHand[] = GameCardHandUtils::formatJson($gameCardHand);
            }
        }
        $gameCardsBattlefield = array();
        if ($player->getBattlefield()->getGameCardsBattlefield()){
            foreach ($player->getBattlefield()->getGameCardsBattlefield() as $gameCardBattlefield){
                $gameCardsBattlefield[] = GameCardBattlefieldUtils::formatJson($gameCardBattlefield);
            }
        }

        $datas = [
            'player'       =>  $player->getId(),
            'exile'        =>  [
                'count'    =>  $player->getExile()->countGameCardsExile(),
                'cards'    =>  $gameCardsExile,
                'topCard'  =>  GameCardExileUtils::formatJson($this->exileService->topCard($player->getExile())),
            ],
            'graveyard'    =>  [
                'count'    =>  $player->getGraveyard()->countGameCardsGraveyard(),
                'cards'    =>  $gameCardsGraveyard,
                'topCard'  =>  GameCardGraveyardUtils::formatJson($this->graveyardService->topCard($player->getGraveyard())),
            ],
            'library'      =>  [
                'count'    =>  $player->getLibrary()->countGameCardsLibrary(),
                'cards'    =>  $gameCardsLibrary,
                'topCard'  =>  GameCardLibraryUtils::formatJson($this->libraryService->topCard($player->getLibrary())),
            ],
            'hand'         =>  [
                'count'    =>  $player->getHand()->countGameCardsHand(),
                'cards'    =>  $gameCardsHand,
            ],
            'battlefield'  =>  [
                'count'    =>  $player->getBattlefield()->countGameCardsBattlefield(),
                'cards'    =>  $gameCardsBattlefield,
            ],
        ];

        return $datas;
    }

    /**
     * @param Player $player
     * @param array $datas
     * @param int $quantity
     * @return Player
     */
    public function lifepoint(Player $player, array $datas, ?int $quantity = 1): Player
    {
        $lifepoint = $player->getLifepoint();
        if ($datas['operation'] == 'plus'){
            $lifepoint += $quantity;
        }
        if ($datas['operation'] == 'minus'){
            $lifepoint -= $quantity;
        }
        $player->setLifepoint($lifepoint);
        $this->em->persist($player);
        $this->em->flush();
        return $player;
    }

}