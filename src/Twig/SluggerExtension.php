<?php 
namespace App\Twig;

use App\Utils\Slugger;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SluggerExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('slugify', [$this, 'slugify']),
        ];
    }

    public function slugify($text)
    {
        return Slugger::slugify($text);
    }
}
