<?php
namespace App\Repository\Course;

use Doctrine\ORM\EntityRepository;

class Chapter extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function createBaseQuery()
    {
        $queryBuilder = $this->createQueryBuilder('c');
        return $queryBuilder;
    }

    /**
     * @param $courseId
     * @return \App\Entity\Course\Chapter[]
     */
    public function getAllChaptersByCourse($courseId)
    {
        $queryBuilder = $this->createBaseQuery();
        $queryBuilder->innerJoin('c.course', 'c2')
            ->andWhere('c2.identity = :c_id')
            ->orderBy('c.position', 'ASC')
            ->setParameter('c_id', $courseId);

        return $queryBuilder->getQuery()->getResult();
    }
}
