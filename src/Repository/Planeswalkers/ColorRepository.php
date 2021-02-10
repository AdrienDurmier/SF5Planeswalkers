<?php

namespace App\Repository\Planeswalkers;

use App\Entity\Planeswalkers\Color;
use Doctrine\ORM\EntityRepository;

class ColorRepository extends EntityRepository
{
    /**
     * @param array $filtres
     * @return Color[]
     */
    public function search($filtres = array())
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.id', 'ASC');
        $results = $qb->getQuery()->getResult();
        return $results;
    }
}
