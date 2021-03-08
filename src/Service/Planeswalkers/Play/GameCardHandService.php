<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Player;
use App\Entity\Planeswalkers\Play\GameCardHand;
use App\Entity\Planeswalkers\Card;
use App\Utils\Planeswalkers\Play\GameCardHandUtils;

class GameCardHandService
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Card $card
     * @param int $weight
     * @return GameCardHand
     */
    public function new(Card $card, int $weight): GameCardHand
    {
        $gameCard = new GameCardHand();
        $gameCard->setCard($card);
        $gameCard->setWeight($weight);
        $gameCard->setManaCost($card->getManaCost());
        $gameCard->setReveal(false);

        $this->em->persist($gameCard);
        return $gameCard;
    }

    /**
     * @param Player $player
     * @return array
     */
    public function start(Player $player): array
    {
        $gameCardsHand = array();
        if ($player->getHand()->getGameCardsHand()) {
            foreach ($player->getHand()->getGameCardsHand() as $gameCardHand) {
                $gameCardsHand[] = [
                    'id'         => $gameCardHand->getId(),
                    'idScryfall' => $gameCardHand->getCard()->getIdScryfall(),
                    'image'      => $gameCardHand->getCard()->getImageUrisPng(),
                ];
            }
        }
        return $gameCardsHand;
    }
}