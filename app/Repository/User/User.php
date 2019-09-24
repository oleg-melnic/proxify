<?php

namespace App\Repository\User;

use Doctrine\ORM\EntityRepository;

/**
 * Class User
 * @package App\Repository\User
 */
class User extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function createBaseQuery()
    {
        $queryBuilder = $this->createQueryBuilder('u');
        return $queryBuilder;
    }

    /**
     * @param integer $eventId
     * @param integer $exceptUserId
     * @return \App\Entity\User\UserAbstract[]
     */
    public function getUsersByOfflineEvents($eventId, $exceptUserId=null)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->innerJoin('u.offlineEvents', 'oe')
            ->andWhere('oe.identity = :e_id')
            ->setParameter('e_id', $eventId);
        if (!is_null($exceptUserId)) {
            $queryBuilder->andWhere('u.identity <> :u_id')
                ->setParameter('u_id', $exceptUserId);
        }
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param integer $eventId
     * @param integer $userId
     * @return integer
     */
    public function isSubscribedToOfflineEvent($eventId, $userId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->select('count(DISTINCT u.identity)')
            ->innerJoin('u.offlineEvents', 'oe')
            ->andWhere('oe.identity = :e_id')
            ->andWhere('u.identity = :u_id')
            ->setParameter('e_id', $eventId)
            ->setParameter('u_id', $userId);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
