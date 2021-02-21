<?php

namespace App\Service\Planeswalkers\Play\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Play\GameCardHand;
use App\Service\Planeswalkers\Play\LibraryService;
use App\Service\Planeswalkers\Play\GameCardExileService;
use App\Service\Planeswalkers\Play\GameCardGraveyardService;
use App\Service\Planeswalkers\Play\GameCardLibraryService;
use App\Service\Planeswalkers\Play\GameCardHandService;

class MoveService
{
    private $em;
    private $libraryService;
    private $gameCardExileService;
    private $gameCardGraveyardService;
    private $gameCardLibraryService;
    private $gameCardHandService;

    /**
     * @param EntityManagerInterface $em
     * @param LibraryService $libraryService
     * @param GameCardExileService $gameCardExileService
     * @param GameCardGraveyardService $gameCardGraveyardService
     * @param GameCardLibraryService $gameCardLibraryService
     * @param GameCardHandService $gameCardHandService
     */
    public function __construct(EntityManagerInterface $em,
                                LibraryService $libraryService,
                                GameCardExileService $gameCardExileService,
                                GameCardGraveyardService $gameCardGraveyardService,
                                GameCardLibraryService $gameCardLibraryService,
                                GameCardHandService $gameCardHandService)
    {
        $this->em = $em;
        $this->libraryService = $libraryService;
        $this->gameCardExileService = $gameCardExileService;
        $this->gameCardGraveyardService = $gameCardGraveyardService;
        $this->gameCardLibraryService = $gameCardLibraryService;
        $this->gameCardHandService = $gameCardHandService;
    }

    /**
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
     * @param int $quantity
     * @return bool
     */
    public function mills(Player $player, int $quantity = 1)
    {
        $library = $player->getLibrary();
        $graveyard = $player->getGraveyard();

        for($i=0; $i<$quantity; $i++){
            // Récupération de la carte du dessus
            $gameCardLibrary = $this->libraryService->topCard($library);
            if ($gameCardLibrary){
                // Ajout dans le cimetière
                $gameCard = $this->gameCardGraveyardService->new($gameCardLibrary->getCard(), $graveyard->countGameCardsGraveyard() + 1 );
                $graveyard->addGameCardsGraveyard($gameCard);
                // Suppression dans la librairie
                $library->removeGameCardsLibrary($gameCardLibrary);
            }
        }
        $this->em->persist($library);
        return 'mills';
    }

    /**
     * @param Player $player
     * @param int $card
     * @return bool
     */
    public function discard(Player $player, int $card)
    {
        $hand = $player->getHand();
        $graveyard = $player->getGraveyard();

        $cardHand = $this->em->getRepository(GameCardHand::class)->find($card);
        if ($cardHand){
            // Ajout dans le cimetière
            $gameCardGraveyard = $this->gameCardGraveyardService->new($cardHand->getCard(), $graveyard->countGameCardsGraveyard() + 1 );
            $graveyard->addGameCardsGraveyard($gameCardGraveyard);
            // Suppression dans la main
            $hand->removeGameCardsHand($cardHand);
        }

        $this->em->persist($graveyard);

        return 'discard';
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

        // Depuis la main
        if($datas['from'] == 'hand'){
            $cardHand = $this->em->getRepository(GameCardHand::class)->find($datas['card']);
            // Exile
            if ($datas['to'] == 'exile'){
                $gameCardExile = $this->gameCardExileService->new($cardHand->getCard(), $exile->countGameCardsExile() + 1 );
                $exile->addGameCardsExile($gameCardExile);
                $this->em->persist($exile);
            }
            // Discard (Défausse)
            if ($datas['to'] == 'graveyard'){
                $gameCardGraveyard = $this->gameCardGraveyardService->new($cardHand->getCard(), $graveyard->countGameCardsGraveyard() + 1 );
                $graveyard->addGameCardsGraveyard($gameCardGraveyard);
                $this->em->persist($graveyard);
            }
            // from hand on top of library
            if ($datas['to'] == 'library'){
                $gameCardLibrary = $this->gameCardLibraryService->new($cardHand->getCard(), $library->countGameCardsLibrary() + 1 );
                $library->addGameCardsLibrary($gameCardLibrary);
                $this->em->persist($library);
            }
            // Suppression de la carte dans la main
            $hand->removeGameCardsHand($cardHand);
        }
        // Depuis la library
        if($datas['from'] == 'library'){
            // Récupération de la carte du dessus de la library
            $gameCardLibrary = $this->libraryService->topCard($library);
            if ($gameCardLibrary){
                // Exile
                if ($datas['to'] == 'exile'){
                    $gameCardExile = $this->gameCardExileService->new($gameCardLibrary->getCard(), $exile->countGameCardsExile() + 1 );
                    $exile->addGameCardsExile($gameCardExile);
                }
                // Mills (Meulle)
                if ($datas['to'] == 'graveyard'){
                    $gameCardGraveyard = $this->gameCardGraveyardService->new($gameCardLibrary->getCard(), $graveyard->countGameCardsGraveyard() + 1 );
                    $graveyard->addGameCardsGraveyard($gameCardGraveyard);
                }
                // Draw (Pioche)
                if ($datas['to'] == 'hand'){
                    $gameCardHand = $this->gameCardHandService->new($gameCardLibrary->getCard(), $hand->countGameCardsHand() + 1 );
                    $hand->addGameCardsHand($gameCardHand);
                }
                // Suppression dans la librairie
                $library->removeGameCardsLibrary($gameCardLibrary);
            }
        }

        return null;
    }

}