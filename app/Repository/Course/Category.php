<?php
namespace App\Repository\Course;

use Doctrine\ORM\EntityRepository;

class Category extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function createBaseQuery()
    {
        $queryBuilder = $this->createQueryBuilder('c');
        return $queryBuilder;
    }
}
