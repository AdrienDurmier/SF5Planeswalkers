<?php

namespace App\Utils\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardBattlefield;

class GameCardBattlefieldUtils
{
    public static function formatJson(?GameCardBattlefield $gameCardBattlefield)
    {
        if ($gameCardBattlefield == null)
            return null;

        $power = null;
        if ($gameCardBattlefield->getCard()->getPower()){
            $power = $gameCardBattlefield->getCard()->getPower();
        }
        if ($gameCardBattlefield->getPower()){
            $power = $gameCardBattlefield->getPower();
        }
        $toughness = null;
        if ($gameCardBattlefield->getCard()->getToughness()){
            $toughness = $gameCardBattlefield->getCard()->getToughness();
        }
        if ($gameCardBattlefield->getToughness()){
            $toughness = $gameCardBattlefield->getToughness();
        }

        return [
            'id'            => $gameCardBattlefield->getId(),
            'idScryfall'    => $gameCardBattlefield->getCard()->getIdScryfall(),
            'imageUrisPng'  => $gameCardBattlefield->getCard()->getImageUrisPng(),
            'faceDown'      => $gameCardBattlefield->getFaceDown(),
            'tapped'        => $gameCardBattlefield->getTapped(),
            'counter'       => $gameCardBattlefield->getCounter(),
            'power'         => $power,
            'toughness'     => $toughness,
            'note'          => $gameCardBattlefield->getNote(),
            'offsetX'       => $gameCardBattlefield->getOffsetX(),
            'offsetY'       => $gameCardBattlefield->getOffsetY(),
        ];
    }
}