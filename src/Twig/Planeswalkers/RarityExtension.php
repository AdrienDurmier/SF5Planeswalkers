<?php 
namespace App\Twig\Planeswalkers;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RarityExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('rarity', [$this, 'displayRarity']),
        ];
    }

    public function displayRarity($rarity)
    {
        $response = '';
        switch ($rarity) {
            case "common":
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-common" title="Common">C</span>';
                break;
            case "uncommon":
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-uncommon" title="Uncommon">U</span>';
                break;
            case "rare":
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-rare" title="Rare">R</span>';
                break;
            case "mythic":
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-mythic" title="Mythic">M</span>';
                break;
        }
        return $response;
    }
}