<?php
namespace App\Service\Course\Item;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;
use App\Entity\Course\Item\ItemAbstract;
use App\Service\Course\Item\Strategy\Article;
use App\Service\Course\Item\Strategy\Audio;
use App\Service\Course\Item\Strategy\Document;
use App\Service\Course\Item\Strategy\Image;
use App\Service\Course\Item\Strategy\Quiz;
use App\Service\Course\Item\Strategy\Video;

class Item implements CrudInterface
{
    use CrudTrait;

    /**
     * Получить название поля являющееся разделителем inheritance
     *
     * @return string
     */
    public function getDiscriminatorName()
    {
        return 'type';
    }

    /**
     * Получить список поддерживаемых серверов.
     *
     * формат: [
     *   '<имя из сущности>' => '<имя сервиса>'
     * ]
     *
     * @return array
     */
    public function getServicesNames()
    {
        return [
            'article' => Article::class,
            'video' => Video::class,
            'quiz' => Quiz::class,
            'audio' => Audio::class,
            'document' => Document::class,
            'image' => Image::class,
        ];
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return ItemAbstract::class;
    }

//    /**
//     * @return \App\Repository\Course\Item
//     */
//    private function getRepository()
//    {
//        return $this->getInheritanceResolver()->getRepository();
//    }

    /**
     *
     */
    private function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
    }

    /**
     * @param $chapterId
     * @return ItemAbstract[]|null
     */
    public function getAllItemsByChapter($chapterId)
    {
        return $this->getRepository()->getAllItemsByChapter($chapterId);
    }

    /**
     * @param array $params
     * @return ItemAbstract|null
     *
     */
    public function getOne(array $params)
    {
        return $this->getRepository()->findOneBy($params);
    }

    /**
     * Count number of quizes for specific course
     * @param $courseId
     * @return integer
     */
    public function countQuizesByCourse($courseId)
    {
        return $this->getRepository()->countQuizesByCourse($courseId);
    }

    /**
     * Count number of quizes for specific course
     * @param $courseId
     * @return integer
     */
    public function countIssuesByCourse($courseId)
    {
        return $this->getRepository()->countIssuesByCourse($courseId);
    }

    /**
     * @param $chapterId
     * @return ItemAbstract[]|null
     */
    public function getAllIssuesByChapter($chapterId)
    {
        return $this->getRepository()->getAllIssuesByChapter($chapterId);
    }

    /**
     * @param $chapterId
     * @return ItemAbstract[]|null
     */
    public function getAllQuizesByChapter($chapterId)
    {
        return $this->getRepository()->getAllQuizesByChapter($chapterId);
    }

    /**
     * @return \App\Entity\Course\Item\ItemAbstract[]|null
     */
    public function getAllItems()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param integer $identity
     * @return \App\Entity\Course\Item\Quiz\QuizVO
     */
    public function getQuizData($identity)
    {
        $entity = $this->getOne(['identity' => $identity]);
        return $entity->getQuiz();
    }
}
