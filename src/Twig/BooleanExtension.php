<?php 
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BooleanExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('display_boolean', [$this, 'displayBoolean']),
        ];
    }

    public function displayBoolean($entity)
    {
        $response = '';
        if($entity !== null){
            switch ($entity) {
                case 1:
                $response = "Yes";
                break;
                case 0:
                $response =  "No";
                break;
            }
        }
        return $response;
    }
}
