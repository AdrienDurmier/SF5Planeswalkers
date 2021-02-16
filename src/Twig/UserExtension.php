<?php 
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UserExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('connectionStatus', [$this, 'connectionStatus']),
        ];
    }

    public function connectionStatus($status)
    {
        $result = '<i class="fas fa-circle text-muted"></i>';
        if($status === null){
            return $result;
        }
        switch ($status)
        {
            case 0:
                $result = '<span title="Disponible"><i class="fas fa-circle text-success"></i></span>';
                break;
            case 1:
                $result = '<span title="Occupé"><i class="fas fa-circle text-danger"></i></span>';
                break;
            case 2:
                $result = '<span title="Ne pas déranger"><i class="fas fa-minus-circle text-danger"></i></span>';
                break;
            case 3:
                $result = '<span title="Inactif"><i class="fas fa-clock text-warning"></i></span>';
                break;
            case 4:
                $result = '<span title="Absent"><i class="fas fa-clock text-danger"></i></span>';
                break;
            case 5:
                $result = '<span title="Hors-ligne"><i class="fas fa-circle text-secondary"></i></span>';
                break;
        }
        return $result;
    }
}
