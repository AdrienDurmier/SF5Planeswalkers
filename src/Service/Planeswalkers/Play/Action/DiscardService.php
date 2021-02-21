<?php

namespace App\Service\Planeswalkers\Play\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\GameCardHand;
use App\Entity\Planeswalkers\Play\Graveyard;
use App\Entity\Planeswalkers\Play\Player;
use App\Service\Planeswalkers\Play\GameCardGraveyardService;

class DiscardService
{
    private $em;
    private $gameCardGraveyardService;

    /**
     * @param EntityManagerInterface $em
     * @param GameCardGraveyardService $gameCardGraveyardService
     */
    public function __construct(EntityManagerInterface $em, GameCardGraveyardService $gameCardGraveyardService)
    {
        $this->em = $em;
        $this->gameCardGraveyardService = $gameCardGraveyardService;
    }

    /**
     * @param Player $player
     * @param int $card
     * @return Graveyard
     */
    public function discard(Player $player, int $card): Graveyard
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

        return $player->getGraveyard();
    }

}