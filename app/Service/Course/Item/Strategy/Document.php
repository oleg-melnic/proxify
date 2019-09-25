<?php
namespace App\Service\Course\Item\Strategy;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;

class Document implements CrudInterface
{
    use CrudTrait;

    /**
     * @param array $data
     *
     * @return \App\Entity\Course\Item\Document
     */
    public function createEmptyEntity(array $data)
    {
        return new \App\Entity\Course\Item\Document();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Course\Item\Document::class;
    }
}
