<?php

namespace App\Repository\Event;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class Offline extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function createBaseQuery()
    {
        $queryBuilder = $this->createQueryBuilder('e');
        return $queryBuilder;
    }

    /**
     * @param integer $userId
     *
     * @return \App\Entity\Event\Offline[]
     *
     * @throws \Exception
     */
    public function getUpcomingOfflineEvents($userId)
    {
        $now_datetime = new \DateTime();
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->innerJoin('App\Entity\User\UserAbstract', 'u1', 'WITH', '1 = 1')
        ->innerJoin('u1.offlineEvents', 'e2')
        ->where('u1.identity = :u_id')
        ->andWhere('e.identity = e2.identity')
        ->andWhere('e.heldDate >= :now_dt')
        ->setParameter('u_id', $userId)
        ->setParameter('now_dt', $now_datetime);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param integer $userId
     *
     * @return \App\Entity\Event\Offline[]
     *
     * @throws \Exception
     */
    public function getPastOfflineEvents($userId)
    {
        $now_datetime = new \DateTime();
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->innerJoin('App\Entity\User\UserAbstract', 'u1', 'WITH', '1 = 1')
            ->innerJoin('u1.offlineEvents', 'e2')
            ->where('u1.identity = :u_id')
            ->andWhere('e.identity = e2.identity')
            ->andWhere('e.heldDate < :now_dt')
            ->setParameter('u_id', $userId)
            ->setParameter('now_dt', $now_datetime);

        return $queryBuilder->getQuery()->getResult();
    }
}
