<?php

namespace App\Utils\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardGraveyard;

class GameCardGraveyardUtils
{
    public static function formatJson(GameCardGraveyard $gameCardGraveyard)
    {
        return [
            'id'            => $gameCardGraveyard->getId(),
            'idScryfall'    => $gameCardGraveyard->getCard()->getIdScryfall(),
            'imageUrisPng'  => $gameCardGraveyard->getCard()->getImageUrisPng(),
        ];
    }
}