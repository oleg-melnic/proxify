<?php

namespace App\Service\User\Strategy;

use App\Service\User\User;

/**
 * Class Professor
 *
 * @package App\Service\User
 *
 * @method \App\Repository\User\Professor getRepository()
 */
class Professor extends UserAbstract
{
    /**
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\User\Professor::class;
    }

    /**
     * @param array $data
     *
     * @return \App\Entity\User\Professor
     */
    public function createEmptyEntity(array $data)
    {
        $entity = new \App\Entity\User\Professor();
        $entity->setRoleProvider($this->getRoleProvider());

        return $entity;
    }

    /**
     * @return \App\Entity\User\Profressor[]|null
     *
     */
    public function getAll()
    {
        return $this->getRepository()->findAll(
            [
                'type' => User::TYPE_PROFESSOR,
            ]
        );
    }
}
