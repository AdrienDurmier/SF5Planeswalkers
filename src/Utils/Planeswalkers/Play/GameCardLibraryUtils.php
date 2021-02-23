<?php

namespace App\Utils\Planeswalkers\Play;

use App\Entity\Planeswalkers\Play\GameCardLibrary;

class GameCardLibraryUtils
{
    public static function formatJson(?GameCardLibrary $gameCardLibrary)
    {
        if ($gameCardLibrary == null)
            return null;
        return [
            'id'            => $gameCardLibrary->getId(),
            'idScryfall'    => $gameCardLibrary->getCard()->getIdScryfall(),
            'imageUrisPng'  => $gameCardLibrary->getCard()->getImageUrisPng(),
            'reveal'        => $gameCardLibrary->getReveal(),
        ];
    }
}