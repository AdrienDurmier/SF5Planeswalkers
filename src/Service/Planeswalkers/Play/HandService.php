<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Hand;
use App\Entity\Planeswalkers\Play\Player;

class HandService
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
     * @return Hand
     */
    public function new(Player $player): Hand
    {
        $hand = new Hand();
        $hand->setPlayer($player);

        // Pioche 7 cartes de la librairie par défaut
        $this->draw($player, 7);

        $this->em->persist($hand);
        return $hand;
    }

    /**
     * @param Player $player
     * @param int $quantite
     * @return Hand
     */
    public function draw(Player $player, int $quantite): Hand
    {
        $hand = $player->getHand();
        $library = $player->getLibrary();

        for($i=0; $i<$quantite; $i++){
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