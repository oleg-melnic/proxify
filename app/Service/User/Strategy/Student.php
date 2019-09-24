<?php

namespace App\Service\User\Strategy;

use App\Service\User\User;

/**
 * Class Student
 *
 * @package App\Service\User
 *
 * @method \App\Repository\User\Student getRepository()
 */
class Student extends UserAbstract
{
    /**
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\User\Student::class;
    }

    /**
     * @param array $data
     *
     * @return \App\Entity\User\Student
     */
    public function createEmptyEntity(array $data)
    {
        $entity = new \App\Entity\User\Student();
        $entity->setRoleProvider($this->getRoleProvider());

        return $entity;
    }

    /**
     * @return \App\Entity\User\Student[]|null
     *
     */
    public function getAll()
    {
        return $this->getRepository()->findAll(
            [
                'type' => User::TYPE_STUDENT,
            ]
        );
    }
}
