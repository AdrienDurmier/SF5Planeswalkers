<?php

namespace App\Service\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardLibrary;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Planeswalkers\Play\Library;
use App\Entity\Planeswalkers\Play\Player;

class LibraryService
{
    private $em;
    private $gameCardLibraryService;

    /**
     * @param EntityManagerInterface $em
     * @param GameCardLibraryService $gameCardLibraryService
     */
    public function __construct(EntityManagerInterface $em, GameCardLibraryService $gameCardLibraryService)
    {
        $this->em = $em;
        $this->gameCardLibraryService = $gameCardLibraryService;
    }

    /**
     * @param Player $player
     * @return Library
     * @throws Exception
     */
    public function new(Player $player): Library
    {
        $library = new Library();
        $library->setPlayer($player);

        // Génération d'une librairie à partir du deck
        foreach ($player->getDeck()->getCards() as $deck_card){
            for ($i=1; $i <= $deck_card->getQuantite(); $i++){
                $gameCard = $this->gameCardLibraryService->new($deck_card->getCard(), 0);
                $library->addGameCardsLibrary($gameCard);
            }
        }

        // Mélange du deck
        $this->shuffle($library);

        // Persist
        $this->em->persist($library);

        return $library;
    }

    /**
     * @param Library $library
     * @return Library
     */
    public function shuffle(Library $library): Library
    {
        $positions = range(1, $library->getPlayer()->getDeck()->countCards());
        shuffle($positions);

        $positionKey=0;
        foreach ($library->getGameCardsLibrary() as $gameCardLibrary){
            $gameCardLibrary->setWeight($positions[$positionKey]);
            $this->em->persist($gameCardLibrary);
            $positionKey++;
        }
        $this->em->persist($library);

        return $library;
    }

    /**
     * @param Library $library
     * @return GameCardLibrary|null
     */
    public function topCard(Library $library) : ?GameCardLibrary
    {
        foreach($library->getGameCardsLibrary() as $gameCardsLibrary){
            if($gameCardsLibrary->getWeight() == $library->countGameCardsLibrary()){
                return $gameCardsLibrary;
            }
        }
        return null;
    }

}