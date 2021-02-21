<?php

namespace App\Utils\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardExile;

class GameCardExileUtils
{
    public static function formatJson(?GameCardExile $gameCardExile)
    {
        if ($gameCardExile == null)
            return null;
        return [
            'id'            => $gameCardExile->getId(),
            'idScryfall'    => $gameCardExile->getCard()->getIdScryfall(),
            'imageUrisPng'  => $gameCardExile->getCard()->getImageUrisPng(),
        ];
    }
}