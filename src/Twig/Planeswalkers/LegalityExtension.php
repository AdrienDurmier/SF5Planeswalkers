<?php 
namespace App\Twig\Planeswalkers;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LegalityExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('legality', [$this, 'displayLegality']),
        ];
    }

    public function displayLegality($card)
    {
        $response = '';
        switch ($card) {
            case "not_legal":
                $response = '<i class="fas py-3 fa-times text-danger"></i>';
                break;
            case "banned":
                $response = '<i class="fas py-3 fa-ban text-danger"></i>';
                break;
            case "restricted":
                $response = '<i class="fas py-3 fa-exclamation text-warning"></i>';
                break;
            case "legal":
                $response = '<i class="fas py-3 fa-check text-success"></i>';
                break;
        }
        return $response;
    }
}