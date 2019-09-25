<?php
namespace App\Service\Course;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;
use App\Entity\Course\Chapter as CourseChapter;
use App\Service\ServiceAbstract;

class Chapter extends ServiceAbstract implements CrudInterface
{
    use CrudTrait;

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
     * @return CourseChapter
     */
    public function createEmptyEntity()
    {
        return new CourseChapter();
    }

    /**
     * @param array $params
     *
     * @return CourseChapter|null
     */
    public function getOne(array $params)
    {
        return $this->repository->findOneBy($params);
    }

    /**
     * @return CourseChapter[]|null
     */
    public function getAllCourseChapters()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $courseId
     *
     * @return CourseChapter[]|null
     */
    public function getAllChaptersByCourse($courseId)
    {
        return $this->repository->getAllChaptersByCourse($courseId);
    }
}
