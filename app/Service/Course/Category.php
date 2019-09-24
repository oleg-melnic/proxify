<?php
namespace App\Service\Course;

use App\Entity\Course\Category as CourseCategory;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;

/**
 * Service for course category
 */
class Category implements CrudInterface, NoInheritanceAwareInterface
{
    use CrudTrait;
    use NoInheritanceAwareTrait;

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Course\Category::class;
    }

    /**
     * @param array $data
     *
     * @return CourseCategory
     */
    public function createEmptyEntity(array $data)
    {
        return new CourseCategory();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
    }

    /**
     * @param array $params
     * @return CourseCategory|null
     */
    public function getOne(array $params)
    {
        return $this->getRepository()->findOneBy($params);
    }

    /**
     * @return CourseCategory[]|null
     *
     */
    public function getAllCourseCategories()
    {
        return $this->getRepository()->findAll();
    }
}
