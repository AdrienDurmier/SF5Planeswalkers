<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\GameCardBattlefield;
use App\Entity\Planeswalkers\Card;

class GameCardBattlefieldService
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
     * @param array $datas
     * @return GameCardBattlefield
     */
    public function new(Card $card, array $datas): GameCardBattlefield
    {
        $gameCard = new GameCardBattlefield();
        $gameCard->setCard($card);
        $gameCard->setFaceDown(false);
        $gameCard->setCounter(null);
        $gameCard->setPower($card->getPower());
        $gameCard->setToughness($card->getToughness());
        $gameCard->setOffsetX($datas['offsetX']);
        $gameCard->setOffsetY($datas['offsetY']);

        $this->em->persist($gameCard);
        return $gameCard;
    }

    /**
     * @param GameCardBattlefield $gameCardBattlefield
     * @param array $datas
     * @return GameCardBattlefield
     */
    public function edit(GameCardBattlefield $gameCardBattlefield, array $datas): GameCardBattlefield
    {
        if (isset($datas['tapped'])){
            $gameCardBattlefield->setTapped(($datas['tapped']=='true')?true:false);
        }
        if (isset($datas['faceDown'])){
            $gameCardBattlefield->setFaceDown(($datas['faceDown']=='true')?true:false);
        }
        if (isset($datas['counter'])){
            $gameCardBattlefield->setCounter($datas['counter']);
        }
        if (isset($datas['power'])){
            $gameCardBattlefield->setPower($datas['power']);
        }
        if (isset($datas['toughness'])){
            $gameCardBattlefield->setToughness($datas['toughness']);
        }
        if (isset($datas['note']) && $datas['note'] != ''){
            $gameCardBattlefield->setNote($datas['note']);
        }else{
            $gameCardBattlefield->setNote(null);
        }

        $this->em->persist($gameCardBattlefield);
        return $gameCardBattlefield;
    }

}