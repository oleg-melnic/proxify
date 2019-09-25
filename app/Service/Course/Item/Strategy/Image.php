<?php
namespace App\Service\Course\Item\Strategy;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;

class Image implements CrudInterface
{
    use CrudTrait;

    /**
     * @param array $data
     *
     * @return \App\Entity\Course\Item\Image
     */
    public function createEmptyEntity(array $data)
    {
        return new \App\Entity\Course\Item\Image();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Course\Item\Image::class;
    }
}
