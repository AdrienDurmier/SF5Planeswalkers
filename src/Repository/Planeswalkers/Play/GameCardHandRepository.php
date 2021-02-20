<?php

namespace App\Repository\Planeswalkers\Play;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class GameCardHandRepository extends EntityRepository
{
    /**
     * @param string $idScryfall
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function searchOneByIdScryfall(string $idScryfall)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->join('c.card', 'card');
        $qb->andWhere('card.idScryfall = :idScryfall');
        $qb->setParameter('idScryfall', $idScryfall);
        $qb->setMaxResults(1);

        $results = $qb->getQuery()->getOneOrNullResult();

        return $results;
    }
}
