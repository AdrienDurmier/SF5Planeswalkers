<?php

namespace App\Repository\Planeswalkers;

use App\Entity\Planeswalkers\Card;
use Doctrine\ORM\EntityRepository;

class CardRepository extends EntityRepository
{
    /**
     * @param array $filtres
     * @return Card[]
     */
    public function search($filtres = array())
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.id', 'ASC');
        $results = $qb->getQuery()->getResult();
        return $results;
    }
}
