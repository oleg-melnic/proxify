<?php

namespace App\Service\Subscription;

use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;

class SubscriptionPackage implements CrudInterface, NoInheritanceAwareInterface
{
    use CrudTrait;
    use NoInheritanceAwareTrait;

    /**
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Subscription\SubscriptionPackage::class;
    }

    /**
     * @param array $data
     * @return object
     */
    public function createEmptyEntity(array $data)
    {
        return new \App\Entity\Subscription\SubscriptionPackage();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
    }

    public function getAllPackages()
    {
        return $this->getRepository()->findAll();
    }
}
