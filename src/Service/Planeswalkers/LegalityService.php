<?php

namespace App\Service\Planeswalkers;

use App\Service\Planeswalkers\APIScryfall;
use Doctrine\ORM\EntityManagerInterface;

class LegalityService
{
    private $em;
    private $apiScryfall;

    public function __construct(APIScryfall $apiScryfall, EntityManagerInterface $em)
    {
        $this->apiScryfall = $apiScryfall;
        $this->em = $em;
    }

    /**
     * Analyse de la légalité de toutes les cartes d'un deck
     * @param $deck_cards
     * @return array
     * @throws \Doctrine\DBAL\Exception\ServerException
     */
    public function deck($deck_cards)
    {
        $legalities = [];
        $standard = true;
        $future = true;
        $modern = true;
        $legacy = true;
        $pauper = true;
        $vintage = true;
        $penny = true;
        $commander = true;
        $brawl = true;
        $duel = true;
        $oldschool = true;
        foreach($deck_cards as $deck_card){
            $response_card = $this->apiScryfall->interroger('get', 'cards/'.$deck_card->getCard()->getIdScryfall());
            if($response_card->body->legalities->standard == 'not_legal'
                || $response_card->body->legalities->standard == 'banned'
                || ($response_card->body->legalities->standard == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $standard = false;
            }
            if($response_card->body->legalities->future == 'not_legal'
                || $response_card->body->legalities->future == 'banned'
                || ($response_card->body->legalities->future == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $future = false;
            }
            if($response_card->body->legalities->modern == 'not_legal'
                || $response_card->body->legalities->modern == 'banned'
                || ($response_card->body->legalities->modern == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $modern = false;
            }
            if($response_card->body->legalities->legacy == 'not_legal'
                || $response_card->body->legalities->legacy == 'banned'
                || ($response_card->body->legalities->legacy == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $legacy = false;
            }
            if($response_card->body->legalities->pauper == 'not_legal'
                || $response_card->body->legalities->pauper == 'banned'
                || ($response_card->body->legalities->pauper == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $pauper = false;
            }
            if($response_card->body->legalities->vintage == 'not_legal'
                || $response_card->body->legalities->vintage == 'banned'
                || ($response_card->body->legalities->vintage == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $vintage = false;
            }
            if($response_card->body->legalities->penny == 'not_legal'
                || $response_card->body->legalities->penny == 'banned'
                || ($response_card->body->legalities->penny == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $penny = false;
            }
            if($response_card->body->legalities->commander == 'not_legal'
                || $response_card->body->legalities->commander == 'banned'
                || ($response_card->body->legalities->commander == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $commander = false;
            }
            if($response_card->body->legalities->brawl == 'not_legal'
                || $response_card->body->legalities->brawl == 'banned'
                || ($response_card->body->legalities->brawl == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $brawl = false;
            }
            if($response_card->body->legalities->duel == 'not_legal'
                || $response_card->body->legalities->duel == 'banned'
                || ($response_card->body->legalities->duel == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $duel = false;
            }
            if($response_card->body->legalities->oldschool == 'not_legal'
                || $response_card->body->legalities->oldschool == 'banned'
                || ($response_card->body->legalities->oldschool == 'restricted' && $deck_card->getQuantite() + $deck_card->getQuantiteReserve() > 1)){
                $oldschool = false;
            }
        }
        $legalities['standard'] = $standard;
        $legalities['future'] = $future;
        $legalities['modern'] = $modern;
        $legalities['legacy'] = $legacy;
        $legalities['pauper'] = $pauper;
        $legalities['vintage'] = $vintage;
        $legalities['penny'] = $penny;
        $legalities['commander'] = $commander;
        $legalities['brawl'] = $brawl;
        $legalities['duel'] = $duel;
        $legalities['oldschool'] = $oldschool;

        return $legalities;
    }

    /**
     * Analyse de la légalité de toutes les cartes d'un deck
     * @param $deck_cards
     * @return array
     * @throws \Doctrine\DBAL\Exception\ServerException
     */
    public function cards($deck_cards)
    {
        $legalities = [];
        foreach($deck_cards as $deck_card){
            $response_card = $this->apiScryfall->interroger('get', 'cards/'.$deck_card->getCard()->getIdScryfall());
            // Cartes
            $legalities[$deck_card->getCard()->getId()]['carte'] = $response_card->body;
            $legalities[$deck_card->getCard()->getId()]['quantite']   = $deck_card->getQuantite();
            $legalities[$deck_card->getCard()->getId()]['quantite_reserve'] = $deck_card->getQuantiteReserve();
            // Cartes - legality
            $legalities[$deck_card->getCard()->getId()]['standard']   = $response_card->body->legalities->standard;
            $legalities[$deck_card->getCard()->getId()]['future']     = $response_card->body->legalities->future;
            $legalities[$deck_card->getCard()->getId()]['modern']     = $response_card->body->legalities->modern;
            $legalities[$deck_card->getCard()->getId()]['legacy']     = $response_card->body->legalities->legacy;
            $legalities[$deck_card->getCard()->getId()]['pauper']     = $response_card->body->legalities->pauper;
            $legalities[$deck_card->getCard()->getId()]['vintage']    = $response_card->body->legalities->vintage;
            $legalities[$deck_card->getCard()->getId()]['penny']      = $response_card->body->legalities->penny;
            $legalities[$deck_card->getCard()->getId()]['commander']  = $response_card->body->legalities->commander;
            $legalities[$deck_card->getCard()->getId()]['brawl']      = $response_card->body->legalities->brawl;
            $legalities[$deck_card->getCard()->getId()]['duel']       = $response_card->body->legalities->duel;
            $legalities[$deck_card->getCard()->getId()]['oldschool']  = $response_card->body->legalities->oldschool;
        }

        return $legalities;
    }

}