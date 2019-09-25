<?php
namespace App\Service\Course;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;
use App\Entity\Course\Category as CourseCategory;

class Category implements CrudInterface
{
    use CrudTrait;

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
