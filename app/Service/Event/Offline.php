<?php
namespace App\Service\Event;

use App\Entity\Event\Offline as OfflineEventEntity;
use S0mWeb\WTL\Crud\CrudInterface;
use S0mWeb\WTL\Crud\CrudTrait;
use S0mWeb\WTL\Crud\NoInheritanceAwareInterface;
use S0mWeb\WTL\Crud\NoInheritanceAwareTrait;
use S0mWeb\WTL\StdLib\EntityManagerAwareInterface;
use S0mWeb\WTL\StdLib\EntityManagerAwareTrait;

class Offline implements CrudInterface, NoInheritanceAwareInterface
{
    use CrudTrait;
    use NoInheritanceAwareTrait;

    /**
     * @param array $data
     *
     * @return OfflineEventEntity
     */
    public function createEmptyEntity(array $data)
    {
        return new OfflineEventEntity();
    }

    /**
     * Получить имя сущности
     *
     * @return string
     */
    public function getBaseEntityName()
    {
        return \App\Entity\Event\Offline::class;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->getInheritanceResolver()->getRepository();
    }

    /**
     * @param $alias
     * @return OfflineEventEntity|null
     *
     */
    public function findByAlias($alias)
    {
        return $this->getRepository()->findOneByAlias($alias);
    }

    /**
     * Get list of upcoming offline events for current user
     *
     * @param integer $userId
     * @return \App\Entity\Event\Offline[]
     */
    public function getUpcomingOfflineEvents($userId)
    {
        return $this->getRepository()->getUpcomingOfflineEvents($userId);
    }

    /**
     * Get list of past offline events for current user
     *
     * @param integer $userId
     * @return \App\Entity\Event\Offline[]
     */
    public function getPastOfflineEvents($userId)
    {
        return $this->getRepository()->getPastOfflineEvents($userId);
    }
}
