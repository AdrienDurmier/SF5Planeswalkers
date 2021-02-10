<?php

namespace App\Service\Planeswalkers;
use Doctrine\ORM\EntityManagerInterface;

class ProbabilityService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Calcul les probabilités de tirage d'une carte par tour en fonction de sa quantité et du nombre de carte dans le deck.
     * @param $deck
     * @param $deck_cards
     * @return array
     */
    public function tirageParTour($deck, $deck_cards)
    {
        // Soit L la quantité
        // pour le tour 1 -> P=1-[(60-L)/60]x[(59-L)/59]x[(58-L)/58]x[(57-L)/57]x[(56-L)/56]x[(55-L)/55]x[(54-L)/54]
        // pour le tour 2 -> P=1-[(60-L)/60]x[(59-L)/59]x[(58-L)/58]x[(57-L)/57]x[(56-L)/56]x[(55-L)/55]x[(54-L)/54]x[(53-L)/53]
        // pour le tour 3 -> P=1-[(60-L)/60]x[(59-L)/59]x[(58-L)/58]x[(57-L)/57]x[(56-L)/56]x[(55-L)/55]x[(54-L)/54]x[(53-L)/53]x[(52-L)/52]

        $probabilites = [];
        $total_cartes = $deck->countCards();
        $main_depart = 7;

        foreach ($deck_cards as $deck_card){
            $quantite = $deck_card->getQuantite();
            for ($tour = 7; $tour <= 21; $tour++) {
                $tmp = 1;
                for($i = 0; $i<=$tour ; $i++){
                    $tmp *= (($total_cartes - $i) - $quantite) / ($total_cartes - $i);
                }
                $probabilites[$deck_card->getCard()->getId()]['carte']['name'] = $deck_card->getCard()->getName();
                $probabilites[$deck_card->getCard()->getId()]['carte']['image'] = $deck_card->getCard()->getImageUrisArtCrop();
                $probabilites[$deck_card->getCard()->getId()]['quantite'] = $quantite;
                $probabilites[$deck_card->getCard()->getId()]['tour'][$tour] = (1-$tmp)*100;
            }
        }

        return $probabilites;
    }

    function factorial($number){
        if($number <= 1){
            return 1;
        }
        else{
            return $number * $this->factorial($number - 1);
        }
    }

}