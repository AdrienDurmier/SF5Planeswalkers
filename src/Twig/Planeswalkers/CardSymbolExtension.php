<?php 
namespace App\Twig\Planeswalkers;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CardSymbolExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('cardsymbol', [$this, 'cardsymbol']),
        ];
    }

    public function cardsymbol($contenu)
    {
        $regex = '/{\K[^}]*(?=})/m';
        preg_match_all($regex, $contenu, $matches);
        for($i=0; $i<count($matches[0]); $i++){
            $contenu = str_replace('{'.$matches[0][$i].'}', '<div class="card-symbol card-symbol-'.$matches[0][$i].'"></div>', $contenu);
        }
        return $contenu;
    }
}