<?php
namespace App\Service\Course;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;
use App\Entity\Course\Course as CourseEntity;
use App\Service\ServiceAbstract;

class Course extends ServiceAbstract implements CrudInterface
{
    use CrudTrait;

    /**
     * @var \App\Service\Course\Category $categoryService
     */
    protected $categoryService;

    /**
     * @return CourseEntity
     */
    public function createEmptyEntity()
    {
        return new CourseEntity();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Course\Course::class;
    }

    /**
     * @param array $params
     *
     * @return CourseEntity[]|null
     */
    public function getAllCourses()
    {
        return $this->repository->findAll();
    }

    /**
     * @param array $params
     *
     * @return CourseEntity[]|null
     */
    public function getAllCoursesByParam($params)
    {
        if (!is_array($params) || !$params) {
            throw new \App\Service\Exception\InvalidArgument(
                "Invalid argument params, it must be array and must contain at least one element with condition."
            );
        }

        return $this->repository->findAll([
            array($params)
        ]);
    }

    /**
     * @param array $params
     *
     * @return CourseEntity|null
     */
    public function getOne($params)
    {
        if (!is_array($params) || !$params) {
            throw new \App\Service\Exception\InvalidArgument(
                "Invalid argument params, it must be array and must contain at least one element with condition."
            );
        }

        return $this->repository->findOneBy($params);
    }

    /**
     * @param array $data
     *
     * @return \App\Entity\Course\Course
     */
    public function firstSave(array $data)
    {
        $entity = $this->createEmptyEntity();
        $entity->setName($data['name']);
        $entity->setTeacher($data['teacher']);
        $entity->setAuthor($data['author']);
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * @param array  $data
     * @param bool   $flush
     * @param array  $context
     * @param string $permission
     *
     * @return \App\Entity\User\UserAbstract
     */
    public function create(array $data, $flush = true, array $context = [], $permission = __FUNCTION__)
    {
        $entity = $this->getInheritanceResolver()->create($data, $flush, $context, $permission);
        $this->updateCategories($entity, $data);
        return $entity;
    }

    /**
     * @param array|int $identity
     * @param array     $data
     * @param array     $context
     * @param string    $permission
     *
     * @return object
     */
    public function update($identity, array $data, array $context = [], $permission = __FUNCTION__)
    {
        $entity = $this->getInheritanceResolver()->update($identity, $data, $context, $permission);
        $this->updateCategories($entity, $data);
        return $entity;
    }

    /**
     * Метод, который обновляет связи User с Categories
     * Он отвечает за то, чтобы удалить лишние и создать новые связи
     * @param \App\Entity\Course\Course $entity
     * @param $updateData
     */
    protected function updateCategories($entity, array $updateData)
    {
        if (isset($updateData['categories'])) {
            $categoryIds = $updateData['categories'];
        } else {
            return;
        }

        $oldCategoryArray = [];
        foreach ($entity->getCategories() as $category) {
            $oldCategoryArray[$category->getIdentity()] = $category;
        }
        $removeIds = array_diff(array_keys($oldCategoryArray), $categoryIds);
        $addIds = array_diff($categoryIds, array_keys($oldCategoryArray));
        foreach ($removeIds as $removeId) {
            $entity->removeCategory($oldCategoryArray[$removeId]);
        }
        foreach ($addIds as $addId) {
            $category = $this->getCategoryService()->find($addId);
            $entity->addCategory($category);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param \App\Entity\Course\Course $course
     * @return array
     */
    public function convertCategoriesToArray($course)
    {
        $returnArray = [];
        $categories = $course->getCategories();

        if ($categories) {
            foreach ($categories as $category) {
                /** @var \App\Entity\Course\Category $category */
                $returnArray[] = $category->getIdentity();
            }
        }

        return $returnArray;
    }

    /**
     * @return Category
     */
    public function getCategoryService()
    {
        return $this->categoryService;
    }

    /**
     * @param Category $categoryService
     */
    public function setCategoryService(Category $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Create new course
     *
     * @param array $data
     * @return CourseEntity
     */
    public function createNew(array $data)
    {
        $this->getInheritanceResolver()->getFilter()->setValidationGroup(
            ['name', 'description', 'execution', 'howPass', 'difficulty', 'author', 'teacher', 'institution']
        );

        try {
            $result = $this->create($data, true, [], __FUNCTION__);
        } catch (\S0mWeb\WTL\Crud\Exception\ValidationException $e) {
            return ['errors' => $e->getValidationMessages()];
        }

        $this->getInheritanceResolver()->getFilter()->setValidationGroup(InputFilterInterface::VALIDATE_ALL);

        return $result;
    }

    /**
     * Change course data
     *
     * @param int   $identity
     * @param array $data
     *
     * @return CourseEntity
     */
    public function changeData($identity, array $data)
    {
        $this->getInheritanceResolver()->getFilter()->setValidationGroup(
            ['name', 'description', 'execution', 'howPass', 'difficulty', 'author', 'teacher', 'institution']
        );

        try {
            $result = $this->update($identity, $data);
        } catch (\S0mWeb\WTL\Crud\Exception\ValidationException $e) {
            return ['errors' => $e->getValidationMessages()];
        }

        $this->getInheritanceResolver()->getFilter()->setValidationGroup(InputFilterInterface::VALIDATE_ALL);

        return $result;
    }
}
