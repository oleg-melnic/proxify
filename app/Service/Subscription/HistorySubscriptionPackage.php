<?php

namespace App\Service\Subscription;

use App\Crud\CrudInterface;
use App\Crud\CrudTrait;

class HistorySubscriptionPackage implements CrudInterface
{
    use CrudTrait;

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
