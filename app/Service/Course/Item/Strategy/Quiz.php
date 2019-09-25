<?php
namespace App\Service\Course\Item\Strategy;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;

class Quiz implements CrudInterface
{
    use CrudTrait;

    /**
     * @param array $data
     *
     * @return \App\Entity\Course\Item\Quiz
     */
    public function createEmptyEntity(array $data)
    {
        return new \App\Entity\Course\Item\Quiz();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Course\Item\Quiz::class;
    }
}
