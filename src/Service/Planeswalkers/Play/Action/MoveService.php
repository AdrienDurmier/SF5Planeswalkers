<?php

namespace App\Service\Planeswalkers\Play\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Play\GameCardHand;
use App\Entity\Planeswalkers\Play\GameCardBattlefield;
use App\Service\Planeswalkers\Play\ExileService;
use App\Service\Planeswalkers\Play\GraveyardService;
use App\Service\Planeswalkers\Play\LibraryService;
use App\Service\Planeswalkers\Play\GameCardExileService;
use App\Service\Planeswalkers\Play\GameCardGraveyardService;
use App\Service\Planeswalkers\Play\GameCardLibraryService;
use App\Service\Planeswalkers\Play\GameCardHandService;
use App\Service\Planeswalkers\Play\GameCardBattlefieldService;

class MoveService
{
    private $em;
    private $exileService;
    private $graveyardService;
    private $libraryService;
    private $gameCardExileService;
    private $gameCardGraveyardService;
    private $gameCardLibraryService;
    private $gameCardHandService;

    /**
     * @param EntityManagerInterface $em
     * @param ExileService $exileService
     * @param GraveyardService $graveyardService
     * @param LibraryService $libraryService
     * @param GameCardExileService $gameCardExileService
     * @param GameCardGraveyardService $gameCardGraveyardService
     * @param GameCardLibraryService $gameCardLibraryService
     * @param GameCardHandService $gameCardHandService
     * @param GameCardBattlefieldService $gameCardBattlefieldService
     */
    public function __construct(EntityManagerInterface $em,
                                ExileService $exileService,
                                GraveyardService $graveyardService,
                                LibraryService $libraryService,
                                GameCardExileService $gameCardExileService,
                                GameCardGraveyardService $gameCardGraveyardService,
                                GameCardLibraryService $gameCardLibraryService,
                                GameCardHandService $gameCardHandService,
                                GameCardBattlefieldService $gameCardBattlefieldService)
    {
        $this->em = $em;
        $this->exileService = $exileService;
        $this->graveyardService = $graveyardService;
        $this->libraryService = $libraryService;
        $this->gameCardExileService = $gameCardExileService;
        $this->gameCardGraveyardService = $gameCardGraveyardService;
        $this->gameCardLibraryService = $gameCardLibraryService;
        $this->gameCardHandService = $gameCardHandService;
        $this->gameCardBattlefieldService = $gameCardBattlefieldService;
    }

    /**
     * todo à intégrer dans le move mais en ajoutant la quantité (idem meule) ??
     * @param Player $player
     * @param int $quantity
     * @return bool
     */
    public function draw(Player $player, int $quantity = 1)
    {
        $library = $player->getLibrary();
        $hand = $player->getHand();

        for($i=0; $i<$quantity; $i++){
            // Récupération de la carte du dessus
            $gameCardLibrary = $this->libraryService->topCard($library);
            if ($gameCardLibrary){
                // Ajout dans la main
                $gameCard = $this->gameCardHandService->new($gameCardLibrary->getCard(), $hand->countGameCardsHand() + 1 );
                $hand->addGameCardsHand($gameCard);
                // Suppression dans la librairie
                $library->removeGameCardsLibrary($gameCardLibrary);
            }
        }
        $this->em->persist($library);
        return 'draw';
    }

    /**
     * @param Player $player
     * @param array $datas
     * @return bool
     */
    public function move(Player $player, array $datas)
    {
        $exile = $player->getExile();
        $graveyard = $player->getGraveyard();
        $library = $player->getLibrary();
        $hand = $player->getHand();
        $battlefield = $player->getBattlefield();
        $card = null;

        if($datas['from'] == 'exile'){
            $card = $this->exileService->topCard($exile);
            if ($card){
                $exile->removeGameCardsExile($card);
            }
        }

        if($datas['from'] == 'graveyard'){
            $card = $this->graveyardService->topCard($graveyard);
            if ($card){
                $graveyard->removeGameCardsGraveyard($card);
            }
        }

        if($datas['from'] == 'library'){
            $card = $this->libraryService->topCard($library);
            if ($card){
                $library->removeGameCardsLibrary($card);
            }
        }

        if($datas['from'] == 'hand'){
            $card = $this->em->getRepository(GameCardHand::class)->find($datas['card']);
            if ($card){
                $hand->removeGameCardsHand($card);
            }
        }

        if($datas['from'] == 'battlefield'){
            $card = $this->em->getRepository(GameCardBattlefield::class)->find($datas['card']);
            if ($card){
                $battlefield->removeGameCardsBattlefield($card);
            }
        }

        if ($card){
            if ($datas['to'] == 'exile'){
                $gameCardExile = $this->gameCardExileService->new($card->getCard(), $exile->countGameCardsExile() + 1 );
                $exile->addGameCardsExile($gameCardExile);
                $this->em->persist($exile);
            }
            if ($datas['to'] == 'graveyard'){
                $gameCardGraveyard = $this->gameCardGraveyardService->new($card->getCard(), $graveyard->countGameCardsGraveyard() + 1 );
                $graveyard->addGameCardsGraveyard($gameCardGraveyard);
                $this->em->persist($graveyard);
            }
            if ($datas['to'] == 'library'){
                $gameCardLibrary = $this->gameCardLibraryService->new($card->getCard(), $library->countGameCardsLibrary() + 1 );
                $library->addGameCardsLibrary($gameCardLibrary);
                $this->em->persist($library);
            }
            if ($datas['to'] == 'hand'){
                $gameCardHand = $this->gameCardHandService->new($card->getCard(), $hand->countGameCardsHand() + 1 );
                $hand->addGameCardsHand($gameCardHand);
            }
            if ($datas['to'] == 'battlefield'){
                $gameCardBattlefield = $this->gameCardBattlefieldService->new($card->getCard(), $datas);
                $battlefield->addGameCardsBattlefield($gameCardBattlefield);
            }
        }

        return null;
    }

}