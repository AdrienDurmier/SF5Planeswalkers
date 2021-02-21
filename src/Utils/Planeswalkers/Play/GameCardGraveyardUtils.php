<?php

namespace App\Utils\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardGraveyard;

class GameCardGraveyardUtils
{
    public static function formatJson(?GameCardGraveyard $gameCardGraveyard)
    {
        if ($gameCardGraveyard == null)
            return null;
        return [
            'id'            => $gameCardGraveyard->getId(),
            'idScryfall'    => $gameCardGraveyard->getCard()->getIdScryfall(),
            'imageUrisPng'  => $gameCardGraveyard->getCard()->getImageUrisPng(),
        ];
    }
}