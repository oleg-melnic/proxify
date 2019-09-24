<?php

namespace App\Service\Subscription;

use CirclicalUser\Service\AuthenticationService;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;

class ActiveSubscriptionPackage implements CrudInterface, NoInheritanceAwareInterface
{
    use CrudTrait;
    use NoInheritanceAwareTrait;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Subscription\ActiveSubscriptionPackage::class;
    }

    /**
     * @param array $data
     * @return object
     */
    public function createEmptyEntity(array $data)
    {
        return new \App\Entity\Subscription\ActiveSubscriptionPackage();
    }
}
