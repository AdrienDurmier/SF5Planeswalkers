<?php

namespace App\Utils\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardBattlefield;

class GameCardBattlefieldUtils
{
    public static function formatJson(?GameCardBattlefield $gameCardBattlefield)
    {
        if ($gameCardBattlefield == null)
            return null;
        return [
            'id'            => $gameCardBattlefield->getId(),
            'idScryfall'    => $gameCardBattlefield->getCard()->getIdScryfall(),
            'imageUrisPng'  => $gameCardBattlefield->getCard()->getImageUrisPng(),
            'faceDown'      => $gameCardBattlefield->getFaceDown(),
            'tapped'        => $gameCardBattlefield->getTapped(),
            'counter'       => $gameCardBattlefield->getCounter(),
            'power'         => $gameCardBattlefield->getPower(),
            'toughness'     => $gameCardBattlefield->getToughness(),
            'note'          => $gameCardBattlefield->getNote(),
            'offsetX'       => $gameCardBattlefield->getOffsetX(),
            'offsetY'       => $gameCardBattlefield->getOffsetY(),
        ];
    }
}