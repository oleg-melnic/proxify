<?php
namespace App\Service\Course\Item\Strategy;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;

class Video implements CrudInterface
{
    use CrudTrait;

    /**
     * @param array $data
     *
     * @return \App\Entity\Course\Item\Video
     */
    public function createEmptyEntity(array $data)
    {
        return new \App\Entity\Course\Item\Video();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Course\Item\Video::class;
    }
}
