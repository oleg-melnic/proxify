<?php
namespace App\Service\Course\Item\Strategy;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;

class Article implements CrudInterface
{
    use CrudTrait;

    /**
     * @param array $data
     *
     * @return \App\Entity\Course\Item\Article
     */
    public function createEmptyEntity(array $data)
    {
        return new \App\Entity\Course\Item\Article();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Course\Item\Article::class;
    }
}
