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
        $gameCard->setOffsetX($datas['offsetX']);
        $gameCard->setOffsetY($datas['offsetY']);

        $this->em->persist($gameCard);
        return $gameCard;
    }

    /**
     * @param Card $card
     * @param array $datas
     * @return GameCardBattlefield
     */
    public function copy(Card $card, array $datas): GameCardBattlefield
    {
        $gameCardBattlefield = new GameCardBattlefield();
        $gameCardBattlefield->setCard($card);
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
        $gameCardBattlefield->setBattlefield($datas['battlefield']);
        $gameCardBattlefield->setOffsetX($datas['offsetX']);
        $gameCardBattlefield->setOffsetY($datas['offsetY']);

        $this->em->persist($gameCardBattlefield);
        return $gameCardBattlefield;
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

    /**
     * @param GameCardBattlefield $gameCardBattlefield
     * @param array $datas
     * @return GameCardBattlefield
     */
    public function clone(GameCardBattlefield $gameCardBattlefield, array $datas): GameCardBattlefield
    {
        $originalGameCardBattlefield = $this->em->getRepository(GameCardBattlefield::class)->find($datas['card']);
        $datasCopy = [
            'battlefield'   => $originalGameCardBattlefield->getBattlefield(),
            'tapped'        => $originalGameCardBattlefield->getTapped(),
            'faceDown'      => $originalGameCardBattlefield->getFaceDown(),
            'counter'       => $originalGameCardBattlefield->getCounter(),
            'note'          => $originalGameCardBattlefield->getNote(),
            'offsetX'       => $originalGameCardBattlefield->getOffsetX() + 1,
            'offsetY'       => $originalGameCardBattlefield->getOffsetY() + 1,
        ];
        $gameCardBattlefield = $this->copy($originalGameCardBattlefield->getCard(), $datasCopy);

        $this->em->persist($gameCardBattlefield);
        return $gameCardBattlefield;
    }

}