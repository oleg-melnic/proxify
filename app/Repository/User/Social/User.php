<?php

namespace App\Repository\User\Social;

use Doctrine\ORM\EntityRepository;

/**
 * Class User
 * @package App\Repository\User\Social
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
     * @param integer $key
     * @param integer $socialId
     * @return \App\Entity\User\Social\User|null
     */
    public function findMainUserBySocialKeyActive($key, $socialId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->andWhere('u.state.state = :u_state')
            ->andWhere('u.key = :u_key')
            ->andWhere('u.social = :u_social')
            ->setParameter('u_state',  \App\Entity\User\Social\State::AUTHENTICATED)
            ->setParameter('u_key', $key)
            ->setParameter('u_social', $socialId);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
