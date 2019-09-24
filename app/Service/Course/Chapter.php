<?php
namespace App\Service\Course;

use App\Entity\Course\Chapter as CourseChapter;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;

/**
 * Service for course chapter
 */
class Chapter implements CrudInterface, NoInheritanceAwareInterface
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
        return \App\Entity\Course\Chapter::class;
    }

    /**
     * @param array $data
     *
     * @return CourseChapter
     */
    public function createEmptyEntity(array $data)
    {
        return new CourseChapter();
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
     * @return CourseChapter|null
     *
     */
    public function getOne(array $params)
    {
        return $this->getRepository()->findOneBy($params);
    }

    /**
     * @return CourseChapter[]|null
     *
     */
    public function getAllCourseChapters()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param $courseId
     * @return CourseChapter[]|null
     */
    public function getAllChaptersByCourse($courseId)
    {
        return $this->getRepository()->getAllChaptersByCourse($courseId);
    }
}
