<?php

namespace App\Repository\Course;

use Doctrine\ORM\EntityRepository;

class Item extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function createBaseQuery()
    {
        $queryBuilder = $this->createQueryBuilder('i');
        return $queryBuilder;
    }

    /**
     * @param $chapterId
     * @return \App\Entity\Course\Item\ItemAbstract[]
     */
    public function getAllItemsByChapter($chapterId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->innerJoin('i.chapter', 'i2')
            ->andWhere('i2.identity = :ch_id')
            ->setParameter('ch_id', $chapterId)
            ->addSelect("CASE WHEN i INSTANCE OF \App\Entity\Course\Item\Quiz THEN 1 ELSE 0 END AS HIDDEN sortCondType")
            ->addOrderBy('sortCondType', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Count number of quizes for specific course
     * @param $courseId
     */
    public function countQuizesByCourse($courseId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->select('COUNT(DISTINCT(i.identity))')
            ->innerJoin('i.chapter', 'ch')
            ->innerJoin('ch.course', 'c')
            ->andWhere('c.identity = :c_id')
            ->andWhere($queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Quiz'))
            ->setParameter('c_id', $courseId);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Count number of issues (articles, videos, documents) for specific course
     * @param $courseId
     */
    public function countIssuesByCourse($courseId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->select('COUNT(DISTINCT(i.identity))')
            ->innerJoin('i.chapter', 'ch')
            ->innerJoin('ch.course', 'c')
            ->andWhere('c.identity = :c_id')
            ->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Article'),
                $queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Video'),
                $queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Document')
            ))
            ->setParameter('c_id', $courseId);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Get all issues (articles, videos, documents) for chapter
     *
     * @param $chapterId
     * @return \App\Entity\Course\Item\ItemAbstract[]
     */
    public function getAllIssuesByChapter($chapterId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->innerJoin('i.chapter', 'i2')
            ->andWhere('i2.identity = :ch_id')
            ->setParameter('ch_id', $chapterId)
            ->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Article'),
                $queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Video'),
                $queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Document')
            ));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get all quizes for chapter
     *
     * @param $chapterId
     * @return \App\Entity\Course\Item\ItemAbstract[]
     */
    public function getAllQuizesByChapter($chapterId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->innerJoin('i.chapter', 'i2')
            ->andWhere('i2.identity = :ch_id')
            ->setParameter('ch_id', $chapterId)
            ->andWhere($queryBuilder->expr()->isInstanceOf('i', '\App\Entity\Course\Item\Quiz'));

        return $queryBuilder->getQuery()->getResult();
    }
}
