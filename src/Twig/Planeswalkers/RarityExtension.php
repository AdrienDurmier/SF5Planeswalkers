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

    /**
     * @param $rarity
     * @param bool $fulltext
     * @return string
     */
    public function displayRarity($rarity, bool $fulltext = false)
    {
        $response = '';
        switch ($rarity) {
            case "common":
                $text = ($fulltext)?'Common':'C';
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-common" title="Common">'.$text.'</span>';
                break;
            case "uncommon":
                $text = ($fulltext)?'Uncommon':'U';
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-uncommon" title="Uncommon">'.$text.'</span>';
                break;
            case "rare":
                $text = ($fulltext)?'Rare':'R';
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-rare" title="Rare">'.$text.'</span>';
                break;
            case "mythic":
                $text = ($fulltext)?'Mythic':'M';
                $response = '<span class="planeswalkers-rarity planeswalkers-rarity-mythic" title="Mythic">'.$text.'</span>';
                break;
        }
        return $response;
    }
}