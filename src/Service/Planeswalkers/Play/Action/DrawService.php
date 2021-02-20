<?php

namespace App\Service\Planeswalkers\Play\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Hand;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\GameCardHandService;
use App\Service\Planeswalkers\Play\LibraryService;

class DrawService
{
    private $em;
    private $libraryService;
    private $gameCardHandService;

    /**
     * @param EntityManagerInterface $em
     * @param LibraryService $libraryService
     * @param GameCardHandService $gameCardHandService
     */
    public function __construct(EntityManagerInterface $em, LibraryService $libraryService, GameCardHandService $gameCardHandService)
    {
        $this->em = $em;
        $this->libraryService = $libraryService;
        $this->gameCardHandService = $gameCardHandService;
    }

    /**
     * @param Player $player
     * @param int $quantity
     * @return Hand
     */
    public function draw(Player $player, int $quantity): Hand
    {
        $hand = $player->getHand();
        $library = $player->getLibrary();

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

        return $player->getHand();
    }

}