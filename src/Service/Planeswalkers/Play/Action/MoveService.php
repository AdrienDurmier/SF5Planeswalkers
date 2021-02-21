<?php

namespace App\Service\Planeswalkers\Play\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Play\GameCardHand;
use App\Service\Planeswalkers\Play\GameCardGraveyardService;
use App\Service\Planeswalkers\Play\GameCardHandService;
use App\Service\Planeswalkers\Play\LibraryService;

class MoveService
{
    private $em;
    private $libraryService;
    private $gameCardGraveyardService;
    private $gameCardHandService;

    /**
     * @param EntityManagerInterface $em
     * @param LibraryService $libraryService
     * @param GameCardGraveyardService $gameCardGraveyardService
     * @param GameCardHandService $gameCardHandService
     */
    public function __construct(EntityManagerInterface $em, LibraryService $libraryService, GameCardGraveyardService $gameCardGraveyardService, GameCardHandService $gameCardHandService)
    {
        $this->em = $em;
        $this->libraryService = $libraryService;
        $this->gameCardGraveyardService = $gameCardGraveyardService;
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
            $top_card = $this->libraryService->topCard($library);
            if ($top_card){
                // Ajout dans la main
                $gameCard = $this->gameCardHandService->new($top_card->getCard(), $hand->countGameCardsHand() + 1 );
                $hand->addGameCardsHand($gameCard);
                // Suppression dans la librairie
                $library->removeGameCardsLibrary($top_card);
            }
        }
        $this->em->persist($library);
        return true;
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
            $top_card = $this->libraryService->topCard($library);
            if ($top_card){
                // Ajout dans le cimetière
                $gameCard = $this->gameCardGraveyardService->new($top_card->getCard(), $graveyard->countGameCardsGraveyard() + 1 );
                $graveyard->addGameCardsGraveyard($gameCard);
                // Suppression dans la librairie
                $library->removeGameCardsLibrary($top_card);
            }
        }
        $this->em->persist($library);
        return true;
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

        return true;
    }

}