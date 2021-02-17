<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Planeswalkers\Play\Library;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Play\GameCard;

class LibraryService
{
    private $em;
    private $gameCardService;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, GameCardLibraryService $gameCardService)
    {
        $this->em = $em;
        $this->gameCardService = $gameCardService;
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
                $gameCard = $this->gameCardService->new($deck_card->getCard(), 0);
                $library->addGameCardLibrary($gameCard);
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
     * @return $this
     */
    public function shuffle(Library $library)
    {
        $positions = range(1, $library->getPlayer()->getDeck()->countCards());
        shuffle($positions);

        $positionKey=0;
        foreach ($library->getGameCardsLibrary() as $gameCardLibrary){
            $gameCardLibrary->setWeight($positionKey);
            $this->em->persist($gameCardLibrary);
            $positionKey++;
        }

        return $this;
    }
}