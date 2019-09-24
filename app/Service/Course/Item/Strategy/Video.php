<?php
namespace App\Service\Course\Item\Strategy;

use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;

class Video implements CrudInterface, NoInheritanceAwareInterface
{
    use CrudTrait;
    use NoInheritanceAwareTrait;

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
