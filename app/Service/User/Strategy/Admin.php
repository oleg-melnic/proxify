<?php

namespace App\Service\User\Strategy;

use App\Service\User\User;

/**
 * Class Admin
 *
 * @package App\Service\User
 *
 * @method \App\Repository\User\Admin getRepository()
 */
class Admin extends UserAbstract
{
    /**
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\User\Admin::class;
    }

    /**
     * @param array $data
     *
     * @return \App\Entity\User\Admin
     */
    public function createEmptyEntity(array $data)
    {
        $entity = new \App\Entity\User\Admin();
        $entity->setRoleProvider($this->getRoleProvider());

        return $entity;
    }

    /**
     * @return \App\Entity\User\Admin[]|null
     *
     */
    public function getAll()
    {
        return $this->getRepository()->findAll(
            [
                'type' => User::TYPE_ADMIN,
            ]
        );
    }
}
