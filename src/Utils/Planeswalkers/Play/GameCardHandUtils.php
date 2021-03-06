<?php

namespace App\Utils\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardHand;

class GameCardHandUtils
{
    public static function formatJson(?GameCardHand $gameCardHand)
    {
        if ($gameCardHand == null)
            return null;

        return [
            'id'                => $gameCardHand->getId(),
            'idScryfall'        => $gameCardHand->getCard()->getIdScryfall(),
            'imageUrisArtCrop'  => $gameCardHand->getCard()->getImageUrisArtCrop(),
            'name'              => str_replace("'",'',$gameCardHand->getCard()->getName()),
            'manaCost'          => $gameCardHand->getManaCost(),
            'reveal'            => $gameCardHand->getReveal(),
        ];
    }
}